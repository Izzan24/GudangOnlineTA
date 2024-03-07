<?php

if(!function_exists('create_tracking')) {
    function create_tracking($data)
    {
        $model = new \App\Models\TrackingBarangModel;
        return $model->create_tracking($data);
    }
}
