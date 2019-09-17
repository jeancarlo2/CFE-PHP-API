<pre><?php
/**
 * Dev by: m.me/me.wuster
 */

wuuDB::mysql();
wuuDB::setDatabase("wuu_test");
// $schema = json_decode( file_get_contents('my_schema.json') );

#Simulating json object
$schema = (object)[
    "title" =>(object)[
        "type"      => "string",
        "unique"    =>true,
        "required"  =>true
    ],
    "rate" =>(object)[
        "type"  => "number",
        "min"   => 0,
        "max"   => 5,
        "required"  =>true
    ],
    "date" =>(object)[
        "type"          => "date",
        "description"   => "Data do filme",
        "default"       => "return date('y-m-d');"
    ],
    "tags" =>(object)[
        "type"  => "array"
    ]
];

// $schema->rate->default = 'return 4;'; #Eval

// $schema->rate->default = function(){ #Setting direct function
//     return 0;
// };

$schema->rate->default = "defaultrate"; #Setting function name

function defaultrate(){
    return 3.5;
}

$movie  = new wuuModel("Movies", $schema); #create a new Model Object to manage

$movie
    ->set("rate", 1)
    ->set("title", "Aquaman")
    ->set("tags", ["ação", "herois"]);

try {
    $id = $movie->save();
} catch (\Throwable $th) {
    echo $th->getMessage();
    die;
}

// Generate a error
// $movie
//     ->set("rate", 3);
// $id2    = $movie->save();

echo "<code>{$movie->result->queryString}</code><br>INSERT ID::{$id}<hr>";
// var_dump($id2);
$movie
    ->selectFields(['_id','title','rate'])
    ->where([
        ["_id","=",$id]
    ])
    ->by('_id')
    ->order("ASC")
    ->limit(10)
    ->page(1);

echo "<br>";
$exec = $movie->findAll();
echo "<code>{$movie->result->queryString}</code><br>";
var_dump($exec);
echo "<hr>";

$movie->reset();



// Update
$movie
    ->set("rate", 2);
try {
    $up = $movie->save($id);
} catch (\Throwable $th) {
    echo $th->getMessage();
    die;
}
echo "<code>{$movie->result->queryString}</code><br>";
echo "UPDATE ({$up}) ID::{$id}<br>";
$movie
    ->selectFields(['_id','title','rate','date','tags']);
    
echo "<br>";
var_dump($movie->find());
echo "<code>{$movie->result->queryString}</code><br>";
echo "<br>";
$del = $movie->remove($id);
echo "DELETE ({$del}) ID::{$id}";

echo "<br>";
var_dump($movie->result->queryString);
echo "<br>";
wuuDB::dropDatabase("wuu_test");
exit;