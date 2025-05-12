<?php

require 'vendor/autoload.php';

use PhpParser\Error;
use PhpParser\Node;
use PhpParser\NodeTraverser;
use PhpParser\NodeVisitorAbstract;
use PhpParser\ParserFactory;

// Validar argumentos
if ($argc < 3) {
    echo "Uso: php analyze_changes.php <archivo> <líneas_modificadas>\n";
    exit(1);
}

$file = $argv[1];
$lines = explode(',', $argv[2]);

// Verificar si el archivo existe
if (!file_exists($file)) {
    echo "❌ El archivo $file no existe.\n";
    exit(1);
}

// Leer el contenido del archivo
$code = file_get_contents($file);

// Crear el parser
$parser = (new ParserFactory)->create(ParserFactory::PREFER_PHP7);

try {
    // Parsear el código en un AST
    $ast = $parser->parse($code);

    // Crear un NodeTraverser para recorrer el AST
    $traverser = new NodeTraverser();
    $traverser->addVisitor(new class($lines, $file) extends NodeVisitorAbstract {
        private $lines;
        private $file;

        public function __construct($lines, $file) {
            $this->lines = $lines;
            $this->file = $file;
        }

        public function enterNode(Node $node) {
            foreach ($this->lines as $line) {
                // Verificar si la línea modificada está dentro del rango del nodo actual
                if ($node->getStartLine() <= $line && $node->getEndLine() >= $line) {
                    if ($node instanceof Node\Stmt\Function_) {
                        echo "🔍 Validando función: " . $node->name . " en $this->file\n";
                        $this->runPHPCS($this->file, $node->getStartLine(), $node->getEndLine());
                    } elseif ($node instanceof Node\Stmt\ClassMethod) {
                        echo "🔍 Validando método: " . $node->name . " en $this->file\n";
                        $this->runPHPCS($this->file, $node->getStartLine(), $node->getEndLine());
                    } elseif ($node instanceof Node\Expr\Closure) {
                        echo "⚠️ Función anónima detectada. No se requiere validación.\n";
                    } else {
                        echo "🔍 Validando bloque global en $this->file\n";
                        $this->runPHPCS($this->file, $node->getStartLine(), $node->getEndLine());
                    }
                }
            }
        }

        private function runPHPCS($file, $start, $end) {
            // Ejecutar PHPCS en el rango específico
            $command = "vendor/bin/phpcs --standard=phpcs.xml --report=full $file --lines=$start-$end";
            $output = [];
            exec($command, $output, $returnVar);
            echo implode("\n", $output) . "\n";

            if ($returnVar !== 0) {
                file_put_contents('php://stderr', "❌ Errores encontrados en $file en las líneas $start-$end\n");
                exit(1);
            }
        }
    });

    // Recorrer el AST
    $traverser->traverse($ast);

} catch (Error $e) {
    echo '⚠️ Error al parsear el archivo: ', $e->getMessage(), "\n";
    exit(1);
}