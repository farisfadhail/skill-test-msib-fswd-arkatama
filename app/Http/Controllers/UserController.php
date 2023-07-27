<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            "input" => "required|string|max:255",
        ]);

        $array_data = explode(' ', strtoupper($request->input));

        $array_data = array_map(function ($value)
        {
            if (is_string($value))
            {
                $value = str_replace(array("TAHUN", "THN", "TH"), "", $value);
            }
            return $value;
        }, $array_data);

        $name = "";
        $age = "";
        $city = "";

        foreach ($array_data as $idx => $value)
        {
            if (is_numeric($value))
            {
                $age = $value;
                unset($array_data[$idx]);
                break;
            }

            $name .= $value . " ";
            unset($array_data[$idx]);
        }

        $city .= implode(" ", $array_data);

        //$user = User::create([
        //    "name" => trim($name),
        //    "age" => $age,
        //    "city" => trim($city)
        //]);

        $user = [
            "name" => trim($name),
            "age" => $age,
            "city" => trim($city)
        ];

        return response()->json($user);
    }
}
