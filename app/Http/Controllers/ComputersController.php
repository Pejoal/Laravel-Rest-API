<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Computer;

class ComputersController extends Controller
{

  //  php artisan make:controller ComputersController -r [resources]

  // Array of Static Data
  // private static function getData()
  // {
  //   return [
  //     ["id" => 1, "name" => "LG", "origin" => "Korea"],
  //     ["id" => 2, "name" => "Dell", "origin" => "CHINA"],
  //     ["id" => 3, "name" => "Lenovo", "origin" => "DE"],
  //     ["id" => 4, "name" => "HP", "origin" => "US"]
  //   ];
  // }

  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function index()
  {
    //
    return view("computers.index", [
      // "computers" => self::getData()
      "computers" => Computer::all()
    ]);
  }

  /**
   * Show the form for creating a new resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function create()
  {
    //
    return view("computers.create");
  }

  /**
   * Store a newly created resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
   */
  public function store(Request $request)
  {
    //

    $request->validate([
      'computer_name' => "required",
      'computer_origin' => "required",
      // 'computer_price' => "required|integer", // same as down
      'computer_price' => ["required", "integer"],
    ]);

    $computer = new Computer();
    $computer->name = strip_tags($request->input("computer_name"));
    $computer->origin = strip_tags($request->input("computer_origin"));
    $computer->price = strip_tags($request->input("computer_price"));

    $computer->save();

    return redirect()->route("computers.index");
  }

  /**
   * Display the specified resource.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function show($computer) // indeed $computer is the id
  {
    //
    // $computers = self::getData();
    // $index = array_search($computer, array_column($computers, "id"));

    // $index = Computer::find($computer);
    // if ($index === false) {
    //   abort(404);
    // }

    // same as above

    $index = Computer::findOrFail($computer); // indeed $computer is the id

    return view("computers.show", [
      // "computer" => $computers[$index]
      "computer" => $index
    ]);
  }

  /**
   * Show the form for editing the specified resource.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function edit($computer)
  {
    //
    return view("computers.edit", [
      "computer" => Computer::findOrFail($computer)
    ]);
  }

  /**
   * Update the specified resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function update(Request $request, $computer)
  {
    //
    $request->validate([
      'computer_name' => "required",
      'computer_origin' => "required",
      // 'computer_price' => "required|integer", // same as down
      'computer_price' => ["required", "integer"],
    ]);

    $computer = Computer::findOrFail($computer);
    $computer->name = strip_tags($request->input("computer_name"));
    $computer->origin = strip_tags($request->input("computer_origin"));
    $computer->price = strip_tags($request->input("computer_price"));

    $computer->save();

    return redirect()->route("computers.index", $computer);
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function destroy($computer)
  {
    //
    $computer = Computer::findOrFail($computer);
    $computer->delete();
    return redirect()->route("computers.index");
  }
}
