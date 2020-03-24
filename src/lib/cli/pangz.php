<?php
require_once("../config.php");
main($argv);

function main($args) {

    if( !isset($args[1]) ||
        (isset($args[1]) && in_array($args[1], ['--help']))
    ) {
        showHelp();
        exit();
    }

    if(!isset($args[1], $args[2], $args[3])) {
        print"\e[31m[Error] \e[0m Arguments unknown. See the the following!\n ";
        showHelp();
        exit();
    }

    $operation = $args[1];
    $fileType  = $args[2];
    $fileName  = $args[3];
    $extension = $args[4] ?? null;

    if(in_array($fileType, ['mi', 'mid', 'middle', 'middleware'])) {
        $fileType  = 'middleware';
    } elseif(in_array($fileType, ['ro', 'rou', 'rout', 'routing'])) {
        $fileType = 'routing';
    } elseif(in_array($fileType, ['se', 'ser', 'serv', 'service'])) {
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

    $result = $method($param = ['name' => $fileName, "extension" => $extension]);
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
    $propertyList = [];

    $resolveFormat = function($props) {
        return str_replace(" ", "_", $props);
    };
    $createProperty = function($item) {
        $form = "    protected $%s;";
        return sprintf($form, $item);
    };

    if(!is_null($param["extension"])) {
        $propertyList = array_map(
            $createProperty,
            explode(",", $resolveFormat($param["extension"]))
        );
        $param["extension"] = implode("\n", $propertyList);
    }

    return create('MODEL', $param);
}

function create_resource($param) {
    return create('RESOURCE', $param);
}

function create($fileType, $param) {
    
    $type       = strtoupper($fileType);
    $fileName   = $param['name'];
    $sourcePath = str_replace("\\", DS, CLI_PATHS[$type]["template"]);
    $targetPath = str_replace("\\", DS, CLI_PATHS[$type]["target"].DS.$fileName.".php");
    $className  = basename($fileName);
    $classDir   = dirname($targetPath);
    $otherParam = $param["extension"] ?? "";
    $parentDir  = "";
    $stat       = false;

    if(fileHasParentFolder($fileName) && !file_exists($targetPath)) {
        $parentDir = "\\".dirname(str_replace(DS, "\\", $fileName));
        if(!file_exists($classDir)) {
            mkdir(dirname($targetPath), 0775, true);
        }
    }

    if(!file_exists($targetPath)) {
        touch($targetPath);
        chmod($targetPath, 0775);
        $content   = file_get_contents($sourcePath);
        $valueList = [$parentDir, $className, $otherParam];
        $stat      = (
            file_put_contents(
                $targetPath,
                sprintf(
                    $content,
                    ...$valueList
                )
            ) > 0
        );
    }

    //@TODO, update this return. Remove msg.
    return [
        "stat" => $stat,
        "name" => $targetPath,
        "msg"  => "Failed to create file. File might already be existing."
    ];
}

function fileHasParentFolder($dirName) {
    return (bool) strstr(str_replace("\\", DS, $dirName), DS);
}

function showHelp() {
    $mainCmd = "./pangz-cli.sh";
    $l = "\e[35m";
    $c = "\e[32m";
    $e = "\e[0m";
    print "\n$c#####################################################$e\n";
    print "$c#                                                   #$e\n";
    print "$c#     PANGZCL  LIPANG   PA   NG  NGZCLI  ANGZCLI    #$e\n";
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
    print " $mainCmd [operation] [type] [FileName] \n\n";
    $files = ['middleware','model','repository','routing','service', 'resource'];
    $ope   = "create";

    foreach($files as $currentFile) {
        print "$l $mainCmd $ope $currentFile [FileName] $e\n";
    }
}