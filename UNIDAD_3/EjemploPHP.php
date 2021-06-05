<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Titulo</title>
    <?PHP
        require ("conecta.php");
        require ("fecha.php");
        require ("cadena.php");
        require ("globals.php");
    ?>
</head>
<body>
    <?PHP
        include ("cabecera.html");
    ?>
    <!-- Código HTML + PHP -->
    <?PHP
        include ("pie.html");
    ?>
    <?PHP
        $a = 9;
        print 'a vale $a\n';
        print "a vale $a\n";
        print "<IMG SRC='logo.gif'>";
        print "<IMG SRC=\"logo.gif\">";
    ?>
    <?PHP
        $valor = 5;
        print "El valor es: " . $valor . "\n";
        print "El calor es : $valor\n";
    ?>
    <?PHP
        $a = "hola";
        $$a = "mundo";

        print "$a $hola\n";
        print "$a ${$a}";
    ?>
</body>
</html>