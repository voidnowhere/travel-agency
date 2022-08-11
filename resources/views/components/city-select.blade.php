<x-form.select
    label="City" name="city"
    :values="$cities" :value="$value"
    :default="$default"
    :on-change="$onChange" :required="$required"/>
