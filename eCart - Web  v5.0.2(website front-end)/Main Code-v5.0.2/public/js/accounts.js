//"use strict";
//
//$(document).ready(function(){
//    $('select[name=city_id]').select2();
//    $('select[name=area_id]').select2();
//    loadOptions($("select[name=city_id]"), "{{route('cities')}}");
//    loadOptions($("select[name=area_id]"), "{{ route('area', $data['profile']['city_id'] ?? 0 ) }}");
//    $('select[name=city_id]').change(function(){
//        loadOptions($("select[name=area_id]"), "{{ route('area','') }}/" + $('select[name=city_id]').val(), true);
//    });
//});