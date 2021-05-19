<?php
    function returnProvince($key = null){
        $arr = [
                'aceh' => 'Aceh',
                'sumatera utara' => 'Sumatera Utara',
                'sumatera barat' => 'Sumatera Barat',
                'riau' => 'Riau',
                'kepulauan riau' => 'Kepulauan Riau',
                'jambi' => 'Jambi',
                'sumatera selatan' => 'Sumatera Selatan',
                'kepulauan bangka belitung' => 'Kepulauan Bangka Belitung',
                'bengkulu' => 'Bengkulu',
                'lampung' => 'Lampung',
                'dki jakarta' => 'DKI Jakarta',
                'banten' => 'Banten',
                'jawa barat' => 'Jawa Barat',
                'jawa tengah' => 'Jawa Tengah',
                'di yogyakarta' => 'DI Yogyakarta',
                'jawa timur' => 'Jawa Timur',
                'bali' => 'Bali',
                'nusa tenggara barat' => 'Nusa Tenggara Barat',
                'nusa tenggara timur' => 'Nusa Tenggara Timur',
                'kalimantan barat' => 'Kalimantan Barat',
                'kalimantan tengah' => 'Kalimantan Tengah',
                'kalimantan selatan' => 'Kalimantan Selatan',
                'kalimantan timur' => 'Kalimantan Timur',
                'kalimantan utara' => 'Kalimantan Utara',
                'sulawesi utara' => 'Sulawesi Utara',
                'gorontalo' => 'Gorontalo',
                'sulawesi tengah' => 'Sulawesi Tengah',
                'sulawesi barat' => 'Sulawesi Barat',
                'sulawesi selatan' => 'Sulawesi Selatan',
                'sulawesi tenggara' => 'Sulawesi Tenggara',
                'maluku' => 'Maluku',
                'maluku utara' => 'Maluku Utara',
                'papua barat' => 'Papua Barat',
                'papua' => 'Papua',
            ];
        if ($key == null) return $arr;
        if (array_key_exists($key, $arr)) return $arr[$key];
        return "null";
    }
?>
