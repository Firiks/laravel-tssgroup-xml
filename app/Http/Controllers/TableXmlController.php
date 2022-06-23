<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class TableXmlController extends Controller
{
  public function index(Request $request) {
    $sort_by = $request->input('sort_by', false);
    $sort_by_desc = $request->input('sort_by_desc', false);

    $url = env('XML_URL');
    $context  = stream_context_create(array('http' => array('header' => 'Accept: application/xml')));

    $xml = file_get_contents($url, false, $context);
    // $xml = Storage::disk('local')->get('xml/cenik.xml');
    $xml = simplexml_load_string($xml);

    $data = [];

    if( empty($xml) ) abort(500, 'Failed to load XML');

    foreach ($xml as $record) {
      $cat_id = $record->Category->attributes()->{'id'};
      if( strcmp($cat_id[0], 'QI90000101') === 0 ) {
        $data[] = [
          'id' =>(string) $record->ID,
          'name' => (string) $record->Name,
          'shortdescription' =>html_entity_decode( (string) $record->ShortDescription),
          'onstock' => (string) $record->OnStock,
          'picturemain' => (string) $record->PictureMain,
          'weight' => (string) $record->WEIGHT,
        ];
      }
    }

    $data = collect($data);

    if($sort_by) {
      $data = $data->sortBy($sort_by);
    } else if($sort_by_desc) {
      $data = $data->sortByDesc($sort_by_desc);
    }

    return view('table.index', [ 'items' => $data ]);
  }

  public function store(Request $request) {

    $order_items = $request->input('order_data', []);
    $order_count = 0;

    foreach( $order_items as $item ) {
      if(!empty($item['quantity'])) {
        $order_count++;

        $order = new Order();
        $order->quantity = intval($item['quantity']);
        $order->product_id = filter_var($item['product_id'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);

        $order->save();
      }
    }

    if($order_count) {
      $request->session()->flash('success', 'Objednávka spracovaná.');
    } else {
      $request->session()->flash('error', 'Žiadny tovar nebol objednaný.');
    }

    return redirect('/');
  }
}
