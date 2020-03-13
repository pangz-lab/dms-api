<?php
require_once("../config.php");
main($argv);

function main($args) {
    
    if(!isset($args[1],$args[2],$args[3])) {
        print" \e[31m [Error] \e[0m  Arguments does not exist!\n ";
        showHelp();
        exit();
    }

    $operation = $args[1];
    $fileType  = $args[2];
    $fileName  = $args[3];

    if(in_array($fileType, ['mi', 'mid', 'middle'])) {
        $fileType  = 'middleware';
    } elseif(in_array($fileType, ['ro', 'rou', 'routing'])) {
        $fileType = 'routing';
    } elseif(in_array($fileType, ['se', 'ser', 'service'])) {
        $fileType = 'service';
    } elseif(in_array($fileType, ['re', 'rep', 'repo', 'repository'])) {
        $fileType = 'repository';
    } elseif(in_array($fileType, ['mo', 'mod', 'model'])) {
        $fileType = 'model';
    } elseif(in_array($fileType, ['res', 'resource'])) {
        $fileType = 'resource';
    } else {
        $fileType = null;
    }

    if(in_array($operation, ['c','create'])) {
        $operation = 'create';
    } else {
        $operation = null;
    }

    $method = strtolower($operation)."_".strtolower($fileType);
    if(!function_exists($method)) {
        die(" \e[31m [Error] \e[0m  Action does not exist!\n ");
    }

    $result = $method($param = ['name' => $fileName]);
    if($result['stat']) {
        print " \e[32m [OK] \e[0m File successfully created: ".$result['name']."\n";
    } else {
        print " \e[31m [Error] \e[0m".$result['msg']."\n";
    }
}

function create_middleware($param) {
    return create('MIDDLEWARE', $param);
}

function create_routing($param) {
    return create('ROUTING', $param);
}

function create_service($param) {
    return create('SERVICE', $param);
}

function create_repository($param) {
    return create('REPOSITORY', $param);
}

function create_model($param) {
    return create('MODEL', $param);
}

function create_resource($param) {
    return create('RESOURCE', $param);
}

function create($fileType, $param) {
    $type       = strtoupper($fileType);
    $sourcePath = CLI_PATHS[$type]["template"];
    $targetPath = CLI_PATHS[$type]["target"].DS.$param['name'].".php";
    $stat       = false;
    if(!file_exists($targetPath)) {
        touch($targetPath);
        chmod($targetPath, 0775);
        $content = file_get_contents($sourcePath);
        $stat    = (file_put_contents($targetPath ,sprintf($content, $param['name'])) > 0);
    }

    return [
        "stat" => $stat,
        "name" => $targetPath,
        "msg"  => "Failed to create file. File might already been existed."
    ];
}

function showHelp() {
    $l = "\e[35m";
    $c = "\e[32m";
    $e = "\e[0m";
    print "\n$c#####################################################$e\n";
    print "$c#                                                   #$e\n";
    print "$c#    PANGZCL   LIPANG   PA   NG  NGZCLI  ANGZCLI    #$e\n";
    print "$c#    IP    AN ZC    LI ZCLI  PA PA            PAN   #$e\n";
    print "$c#    GZCLIPA  PANGZCLI NG ZC LI NG   ZCL    GZ      #$e\n";
    print "$c#    NG       PA    NG PA  NGZC IP    AN CLI        #$e\n";
    print "$c#    ZC       ZC    LI LI   PA   GZCLIP   PANGZCL   #$e\n";
    print "$c#                                                   #$e\n";
    print "$c#     PANGZCLIPANG  GZC            LIPANGZCLIPAN    #$e\n";
    print "$c#    ZCL            LIP                 GZC         #$e\n";
    print "$c#     IPANGZCLIPAN  ANGZCLIPANGZC  LIPANGZCLIPAN    #$e\n";
    print "$c#                                                   #$e\n";
    print "$c#####################################################$e\n";
    print "\n\n";
    print " pangz [operation] [type] [FileName] \n\n";
    $files = ['middleware','model','repository','routing','service', 'resource'];
    $ope   = "create";

    foreach($files as $currentFile) {
        print "$l pangz $ope $currentFile [FileName] $e\n";
    }
}