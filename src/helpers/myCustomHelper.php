<?php

class MyCustomHelper {

    public function returnCatchAsJson($errorResponse ) {
        return json_encode($errorResponse, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT);
        echo "console.log('entrando a returnCatchAsJson')\n";
    }
   
    public function returnCustomResponseAsJson($customResposne) {
        echo "console.log('entrando a returnCustomResponseAsJson')\n";
        return json_encode($customResposne, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT);
    }
}
