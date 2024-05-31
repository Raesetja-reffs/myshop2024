<?php

namespace App\Traits;

use App\Traits\ApiTrait;

trait UserFeatureTrait
{
    use ApiTrait;

    public function apiGetDimsUsers()
    {
        $response = [
            [
                "UserID" => "1",
                "UserName" => "Admin",
                "Password" => "Linx_123#@!",
                "Administrator" => "1"
            ],
            [
                "UserID" => "2",
                "UserName" => "Adrian",
                "Password" => "Adrian",
                "Administrator" => "0"
            ],
            [
                "UserID" => "72",
                "UserName" => "Adriver1",
                "Password" => "Adriver1",
                "Administrator" => "0"
            ],
            [
                "UserID" => "73",
                "UserName" => "Adriver2",
                "Password" => "Adriver2",
                "Administrator" => "0"
            ],
            [
                "UserID" => "74",
                "UserName" => "Alex",
                "Password" => "Ukzn@2018",
                "Administrator" => "1"
            ],
            [
                "UserID" => "49",
                "UserName" => "Aneen",
                "Password" => "Aneen",
                "Administrator" => "0"
            ],
            [
                "UserID" => "45",
                "UserName" => "Anthea",
                "Password" => "Anthea",
                "Administrator" => "0"
            ],
            [
                "UserID" => "64",
                "UserName" => "Anthony",
                "Password" => "Anthony",
                "Administrator" => "0"
            ],
            [
                "UserID" => "3",
                "UserName" => "Arie",
                "Password" => "Arie",
                "Administrator" => "0"
            ],
            [
                "UserID" => "4",
                "UserName" => "Arno",
                "Password" => "Arno",
                "Administrator" => "0"
            ],
            [
                "UserID" => "65",
                "UserName" => "Austin",
                "Password" => "Austin",
                "Administrator" => "0"
            ],
            [
                "UserID" => "5",
                "UserName" => "Boardroom",
                "Password" => "Boardroom",
                "Administrator" => "0"
            ],
            [
                "UserID" => "50",
                "UserName" => "Brian",
                "Password" => "Brian",
                "Administrator" => "0"
            ],
            [
                "UserID" => "77",
                "UserName" => "Chad",
                "Password" => "Chad",
                "Administrator" => "0"
            ],
            [
                "UserID" => "79",
                "UserName" => "Chanel",
                "Password" => "2012",
                "Administrator" => "1"
            ],
            [
                "UserID" => "81",
                "UserName" => "Chantal",
                "Password" => "Chantal",
                "Administrator" => "0"
            ],
            [
                "UserID" => "7",
                "UserName" => "Charmaine",
                "Password" => "disable",
                "Administrator" => "0"
            ],
            [
                "UserID" => "52",
                "UserName" => "Claude",
                "Password" => "Claude",
                "Administrator" => "0"
            ],
            [
                "UserID" => "80",
                "UserName" => "Claudine",
                "Password" => "Max1",
                "Administrator" => "1"
            ],
            [
                "UserID" => "8",
                "UserName" => "Clifton",
                "Password" => "Clifton",
                "Administrator" => "0"
            ],
            [
                "UserID" => "54",
                "UserName" => "Cornelius",
                "Password" => "Cornelius",
                "Administrator" => "0"
            ],
            [
                "UserID" => "83",
                "UserName" => "Danie",
                "Password" => "Danie",
                "Administrator" => "0"
            ],
            [
                "UserID" => "9",
                "UserName" => "Daphne",
                "Password" => "Daphne",
                "Administrator" => "0"
            ],
            [
                "UserID" => "70",
                "UserName" => "Darryl",
                "Password" => "Darryl",
                "Administrator" => "0"
            ],
            [
                "UserID" => "68",
                "UserName" => "Dylan",
                "Password" => "Dylan",
                "Administrator" => "0"
            ],
            [
                "UserID" => "10",
                "UserName" => "Elvis",
                "Password" => "Elvis",
                "Administrator" => "0"
            ],
            [
                "UserID" => "75",
                "UserName" => "Gainodine",
                "Password" => "Gainodine#@!",
                "Administrator" => "1"
            ],
            [
                "UserID" => "11",
                "UserName" => "George",
                "Password" => "George",
                "Administrator" => "0"
            ],
            [
                "UserID" => "69",
                "UserName" => "Geraldo",
                "Password" => "Geraldo",
                "Administrator" => "0"
            ],
            [
                "UserID" => "12",
                "UserName" => "Gloria",
                "Password" => "Gloria",
                "Administrator" => "0"
            ],
            [
                "UserID" => "13",
                "UserName" => "Gregory",
                "Password" => "Gregory",
                "Administrator" => "0"
            ],
            [
                "UserID" => "60",
                "UserName" => "Hannes",
                "Password" => "Hannes",
                "Administrator" => "0"
            ],
            [
                "UserID" => "56",
                "UserName" => "Hendri",
                "Password" => "1983",
                "Administrator" => "1"
            ],
            [
                "UserID" => "59",
                "UserName" => "Jacobusv",
                "Password" => "Jacobusv",
                "Administrator" => "0"
            ],
            [
                "UserID" => "58",
                "UserName" => "Jacobusz",
                "Password" => "Jacobusz",
                "Administrator" => "0"
            ],
            [
                "UserID" => "61",
                "UserName" => "Jason",
                "Password" => "Jasson",
                "Administrator" => "0"
            ],
            [
                "UserID" => "67",
                "UserName" => "Jaydee",
                "Password" => "Jaydee",
                "Administrator" => "0"
            ],
            [
                "UserID" => "76",
                "UserName" => "JB",
                "Password" => "JB",
                "Administrator" => "0"
            ],
            [
                "UserID" => "66",
                "UserName" => "Jue-Maul",
                "Password" => "Jue-Maul",
                "Administrator" => "0"
            ],
            [
                "UserID" => "62",
                "UserName" => "Kurtly",
                "Password" => "Kurtly",
                "Administrator" => "0"
            ],
            [
                "UserID" => "15",
                "UserName" => "Leanne",
                "Password" => "Leanne",
                "Administrator" => "0"
            ],
            [
                "UserID" => "16",
                "UserName" => "Lee",
                "Password" => "271914",
                "Administrator" => "0"
            ],
            [
                "UserID" => "17",
                "UserName" => "Linda",
                "Password" => "Linda",
                "Administrator" => "0"
            ],
            [
                "UserID" => "18",
                "UserName" => "Liz",
                "Password" => "Liz",
                "Administrator" => "0"
            ],
            [
                "UserID" => "19",
                "UserName" => "Lulu",
                "Password" => "Lulu",
                "Administrator" => "0"
            ],
            [
                "UserID" => "63",
                "UserName" => "Marius",
                "Password" => "Marius",
                "Administrator" => "0"
            ],
            [
                "UserID" => "44",
                "UserName" => "Marnel",
                "Password" => "Marnel",
                "Administrator" => "0"
            ],
            [
                "UserID" => "20",
                "UserName" => "Mervyn",
                "Password" => "Mervyn",
                "Administrator" => "0"
            ],
            [
                "UserID" => "47",
                "UserName" => "Michelle",
                "Password" => "Michelle",
                "Administrator" => "0"
            ],
            [
                "UserID" => "41",
                "UserName" => "Mindre",
                "Password" => "Mindre",
                "Administrator" => "0"
            ],
            [
                "UserID" => "57",
                "UserName" => "Monica",
                "Password" => "4c@2#2",
                "Administrator" => "0"
            ],
            [
                "UserID" => "53",
                "UserName" => "Nadia",
                "Password" => "Nadia",
                "Administrator" => "0"
            ],
            [
                "UserID" => "21",
                "UserName" => "Nicole",
                "Password" => "321Pass!",
                "Administrator" => "1"
            ],
            [
                "UserID" => "22",
                "UserName" => "Nigel",
                "Password" => "@Tx870",
                "Administrator" => "1"
            ],
            [
                "UserID" => "23",
                "UserName" => "Peter",
                "Password" => "2509",
                "Administrator" => "1"
            ],
            [
                "UserID" => "0",
                "UserName" => "PODuser",
                "Password" => "Linx_123#@!",
                "Administrator" => "1"
            ],
            [
                "UserID" => "24",
                "UserName" => "Reception",
                "Password" => "Reception",
                "Administrator" => "0"
            ],
            [
                "UserID" => "84",
                "UserName" => "Reginald",
                "Password" => "Reginald",
                "Administrator" => "0"
            ],
            [
                "UserID" => "25",
                "UserName" => "Rene",
                "Password" => "Rene",
                "Administrator" => "0"
            ],
            [
                "UserID" => "26",
                "UserName" => "Rider",
                "Password" => "Rider",
                "Administrator" => "0"
            ],
            [
                "UserID" => "27",
                "UserName" => "Robbie",
                "Password" => "Robbie",
                "Administrator" => "0"
            ],
            [
                "UserID" => "85",
                "UserName" => "Robin",
                "Password" => "Robin",
                "Administrator" => "0"
            ],
            [
                "UserID" => "28",
                "UserName" => "Rodemeo",
                "Password" => "Rodemeo",
                "Administrator" => "0"
            ],
            [
                "UserID" => "29",
                "UserName" => "Ronel",
                "Password" => "Ronel",
                "Administrator" => "0"
            ],
            [
                "UserID" => "55",
                "UserName" => "RonelC",
                "Password" => "Jernel",
                "Administrator" => "0"
            ],
            [
                "UserID" => "30",
                "UserName" => "Rudy",
                "Password" => "anroe3009",
                "Administrator" => "1"
            ],
            [
                "UserID" => "40",
                "UserName" => "Samantha",
                "Password" => "Samantha",
                "Administrator" => "0"
            ],
            [
                "UserID" => "82",
                "UserName" => "Samantha",
                "Password" => "Samantha",
                "Administrator" => "0"
            ],
            [
                "UserID" => "71",
                "UserName" => "Sammy",
                "Password" => "Sammy",
                "Administrator" => "0"
            ],
            [
                "UserID" => "31",
                "UserName" => "Sandra",
                "Password" => "Sandra",
                "Administrator" => "0"
            ],
            [
                "UserID" => "32",
                "UserName" => "Santie",
                "Password" => "Santie",
                "Administrator" => "0"
            ],
            [
                "UserID" => "33",
                "UserName" => "Senobia",
                "Password" => "Senobia",
                "Administrator" => "0"
            ],
            [
                "UserID" => "34",
                "UserName" => "Stoffie",
                "Password" => "Stoffie",
                "Administrator" => "0"
            ],
            [
                "UserID" => "78",
                "UserName" => "Suleiman",
                "Password" => "Suleiman",
                "Administrator" => "0"
            ],
            [
                "UserID" => "35",
                "UserName" => "Sussie",
                "Password" => "Sussie",
                "Administrator" => "0"
            ],
            [
                "UserID" => "36",
                "UserName" => "Tim",
                "Password" => "Tim",
                "Administrator" => "0"
            ],
            [
                "UserID" => "37",
                "UserName" => "Willie",
                "Password" => "Willie",
                "Administrator" => "0"
            ],
            [
                "UserID" => "38",
                "UserName" => "Yandi",
                "Password" => "Yandi",
                "Administrator" => "0"
            ]
        ];

        return $response;
    }
}
