<?php

namespace App\Services;

use App\Models\Housing;
use App\Models\Order;
use App\Models\OrderPriceDetail;
use App\Models\OrderStatusDetail;
use App\Models\Season;
use Illuminate\Database\Eloquent\Collection;

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
                    fn($query) => $query->where('date_from', '<=', $order->date_to)->where('date_to', '>=', $order->date_to)
                )->orWhere(
                    fn($query) => $query->where('date_to', '<=', $order->date_to)->where('date_to', '>=', $order->date_from)
                )->orderBy('date_from')->get(['type_SHML', 'date_from', 'date_to']);

        // Check If Seasons Have Gap
        if (static::seasonsHaveGap($seasons, $order->id)) {
            return false;
        }

        $orderHousing = $order->housing;

        // Check If Housing Capacity Exceeded
        if (static::housingCapacityExceeded($order->for_count, $orderHousing->for_max, $order->id)) {
            return false;
        }

        // Check For Inappropriate Housing
        if (static::inappropriateHousing($orderHousing->for_max, $order->for_count, $order->id)) {
            return false;
        }

        $orderDays = $order->date_from->diffInDays($order->date_to);

        // Order Will Be In One Season
        if ($seasons->count() === 1) {
            if (!static::processPriceForASeason($orderHousing, $seasons[0]->type_SHML, $orderDays, $order->for_count, $order->id)) {
                return false;
            }
            $order->setToProcessed();
            return true;
        }

        // If Order Will Be In More Than One Season
        for ($i = 0; $i < $seasons->count(); $i++) {
            $orderSeasonDays = 0;
            if ($i === 0) {
                $orderSeasonDays = $order->date_from->diffInDays($seasons[$i]->date_to) + 1;
            } elseif ($i === $seasons->count() - 1) {
                $orderSeasonDays = $seasons[$i]->date_from->diffInDays($order->date_to);
            } else {
                $orderSeasonDays = $seasons[$i]->date_from->diffInDays($seasons[$i]->date_to) + 1;
            }
            if (!static::processPriceForASeason($orderHousing, $seasons[$i]->type_SHML, $orderSeasonDays, $order->for_count, $order->id)) {
                return false;
            }
        }

        $order->setToProcessed();

        return true;
    }

    protected static function processPriceForASeason(
        Housing $orderHousing,
        string  $seasonType,
        int     $orderDays,
        int     $orderForCount,
        int     $orderId
    ): bool
    {
        $housingPrice = $orderHousing->prices()->firstWhere('type_SHML', '=', $seasonType);

        if (static::housingHasNoPrice($housingPrice, $orderId, $seasonType)) {
            return false;
        }

        // Check If Order Days Are Not Enough
        if (static::orderDaysAreNotEnough($housingPrice->min_nights, $orderDays, $orderId, $seasonType)) {
            return false;
        }

        $orderPrice = ($housingPrice->for_one_price * $orderDays) * $orderForCount;
        $orderPrice += ($orderForCount < $orderHousing->for_max) ? ($housingPrice->for_one_extra_price * $orderDays) : 0;

        OrderPriceDetail::create([
            'order_id' => $orderId,
            'type_SHML' => $seasonType,
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
                    'description' => "Unavailable Season From $seasonDateToPlusOneDay To " . $seasonDateToPlusOneDay->subDays(1),
                ]);
                return true;
            }
        }
        return false;
    }

    protected static function housingHasNoPrice($housingPrice, int $orderId, string $seasonType): bool
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

    protected static function inappropriateHousing(
        int $housingMax,
        int $orderForCount,
        int $orderId
    ): bool
    {
        if ($housingMax - $orderForCount > 1) {
            OrderStatusDetail::create([
                'order_id' => $orderId,
                'description' => 'Inappropriate Housing',
            ]);
            return true;
        }
        return false;
    }
}
