<?php

namespace App\Services;

use App\Models\Housing;
use App\Models\HousingPrice;
use App\Models\Order;
use App\Models\OrderPriceDetail;
use App\Models\OrderStatusDetail;
use App\Models\Season;
use Carbon\CarbonPeriod;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Carbon;

class OrderService
{
    public static function processPrice(Order $order, bool $isOrderNew = false): bool
    {
        // Clean Order Details
        if (!$isOrderNew) {
            $order->statusDetails()->delete();
            $order->priceDetails()->delete();
            $order->setToUnavailable();
        }

        // Get Appropriate Season
        $seasons =
            Season::where('date_from', '<=', $order->date_from)
                ->orWhere(
                    fn($query) => $query->where('date_from', '<', $order->date_to)->where('date_to', '>=', $order->date_to)
                )->orWhere(
                    fn($query) => $query->where('date_to', '<=', $order->date_to)->where('date_to', '>', $order->date_from)
                )->orderBy('date_from')->get(['type_SHML', 'date_from', 'date_to']);

        // Check If Seasons Have Gap
        if (static::seasonsHaveGap($seasons, $order->id)) {
            return false;
        }

        $orderHousing = $order->housing()->get(['id', 'for_max'])->first();

        // Check If Housing Capacity Exceeded
        if (static::housingCapacityExceeded($order->for_count, $orderHousing->for_max, $order->id)) {
            return false;
        }

//        // Check For Inappropriate Housing
//        if (static::inappropriateHousing($orderHousing->for_max, $order->for_count, $order->id)) {
//            return false;
//        }

        $residenceTax = $order->residence()->get(['tax'])->first()->tax;

        // Order Will Be In One Season
        if ($seasons->count() === 1) {
            if (!static::processPriceForASeason(
                orderHousing: $orderHousing,
                seasonDateFromStartByOrder: $order->date_from,
                seasonDateToEndByOrder: $order->date_to->subDays(1),
                seasonType: $seasons[0]->type_SHML,
                orderDaysCount: $order->date_from->diffInDays($order->date_to),
                orderForCount: $order->for_count,
                orderId: $order->id,
                residenceTax: $residenceTax,
            )) {
                return false;
            }

            $order->setToProcessed();

            return true;
        }

        // If Order Will Be In More Than One Season
        for ($i = 0; $i < $seasons->count(); $i++) {
            $orderSeasonDaysStartEndByOrder = 0;
            $dateFrom = null;
            $dateTo = null;
            if ($i === 0) {
                $orderSeasonDaysStartEndByOrder = $order->date_from->diffInDays($seasons[$i]->date_to) + 1;
                $dateFrom = $order->date_from;
                $dateTo = $seasons[$i]->date_to;
            } elseif ($i === $seasons->count() - 1) {
                $orderSeasonDaysStartEndByOrder = $seasons[$i]->date_from->diffInDays($order->date_to);
                $dateFrom = $seasons[$i]->date_from;
                $dateTo = $order->date_to->subDays(1);
            } else {
                $orderSeasonDaysStartEndByOrder = $seasons[$i]->date_from->diffInDays($seasons[$i]->date_to) + 1;
                $dateFrom = $seasons[$i]->date_from;
                $dateTo = $seasons[$i]->date_to;
            }

            if (!static::processPriceForASeason(
                orderHousing: $orderHousing,
                seasonDateFromStartByOrder: $dateFrom,
                seasonDateToEndByOrder: $dateTo,
                seasonType: $seasons[$i]->type_SHML,
                orderDaysCount: $orderSeasonDaysStartEndByOrder,
                orderForCount: $order->for_count,
                orderId: $order->id,
                residenceTax: $residenceTax,
            )) {
                return false;
            }
        }

        $order->setToProcessed();

        return true;
    }


    protected static function processPriceForASeason(
        Housing $orderHousing,
        Carbon  $seasonDateFromStartByOrder,
        Carbon  $seasonDateToEndByOrder,
        string  $seasonType,
        int     $orderDaysCount,
        int     $orderForCount,
        int     $orderId,
        float   $residenceTax,
    ): bool
    {
        $housingPrice = $orderHousing->prices()
            ->where('type_SHML', '=', $seasonType)
            ->get(['min_nights', 'for_one_price', 'extra_price', 'extra_price_is_active', 'weekends', 'weekend_price', 'weekend_is_active'])
            ->first();

        // Check If Housing Price Has No Price
        if (static::housingHasNoPrice($housingPrice, $orderId, $seasonType)) {
            return false;
        }

        // Check If Order Days Are Not Enough
        if (static::orderDaysAreNotEnough($housingPrice->min_nights, $orderDaysCount, $orderId, $seasonType)) {
            return false;
        }

        $orderPrice = ($housingPrice->for_one_price + $residenceTax) * $orderDaysCount * $orderForCount;
        $orderPrice += ($housingPrice->extra_price_is_active && $orderForCount < $orderHousing->for_max)
            ? ($housingPrice->extra_price * $orderDaysCount * ($orderHousing->for_max - $orderForCount))
            : 0;
        $orderPrice += ($housingPrice->weekend_is_active)
            ? $housingPrice->weekend_price * $orderForCount * static::countWeekends(CarbonPeriod::create($seasonDateFromStartByOrder, $seasonDateToEndByOrder)->toArray(), $housingPrice->weekendsArray())
            : 0;

        OrderPriceDetail::create([
            'order_id' => $orderId,
            'type' => "$seasonType Season",
            'price' => $orderPrice,
        ]);

        return true;
    }

    protected static function seasonsHaveGap(Collection $seasons, int $orderId): bool
    {
        for ($i = 0; $i < $seasons->count() - 1; $i++) {
            $seasonDateToPlusOneDay = $seasons[$i]->date_to->addDay(1);
            $forwardSeasonDateFrom = $seasons[$i + 1]->date_from;
            if (!$seasonDateToPlusOneDay->equalTo($forwardSeasonDateFrom)) {
                OrderStatusDetail::create([
                    'order_id' => $orderId,
                    'description' => "Unavailable Season From " . $seasonDateToPlusOneDay->toDateString() . " To " . $seasonDateToPlusOneDay->subDays(1)->toDateString(),
                ]);
                return true;
            }
        }
        return false;
    }

    protected static function housingHasNoPrice(HousingPrice|null $housingPrice, int $orderId, string $seasonType): bool
    {
        if ($housingPrice === null) {
            OrderStatusDetail::create([
                'order_id' => $orderId,
                'description' => "Unavailable Housing Price For $seasonType Season",
            ]);
            return true;
        }
        return false;
    }

    protected static function orderDaysAreNotEnough(
        int    $minNights,
        int    $orderDays,
        int    $orderId,
        string $seasonType
    ): bool
    {
        if ($minNights > $orderDays) {
            OrderStatusDetail::create([
                'order_id' => $orderId,
                'description' => "Order Days Not Enough For $seasonType Season $minNights Minimum $orderDays Given",
            ]);
            return true;
        }
        return false;
    }

    protected static function housingCapacityExceeded(
        int $orderForCount,
        int $housingMax,
        int $orderId
    ): bool
    {
        if ($orderForCount > $housingMax) {
            OrderStatusDetail::create([
                'order_id' => $orderId,
                'description' => 'Exceeded Housing Capacity',
            ]);
            return true;
        }
        return false;
    }

    protected static function countWeekends(
        array $dates,
        array $weekdayNums
    ): int
    {
        $count = 0;
        foreach ($dates as $date) {
            if (in_array($date->weekday(), $weekdayNums)) {
                $count++;
            }
        }
        return $count;
    }

//    protected static function inappropriateHousing(
//        int $housingMax,
//        int $orderForCount,
//        int $orderId
//    ): bool
//    {
//        if ($housingMax - $orderForCount > 1) {
//            OrderStatusDetail::create([
//                'order_id' => $orderId,
//                'description' => 'Inappropriate Housing',
//            ]);
//            return true;
//        }
//        return false;
//    }
}
