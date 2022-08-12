<x-form.select
    label="Residence" name="residence"
    :values="$residences" :value="$value"
    :default="$default" :required="$required"
    :on-change="$onChange"/>
