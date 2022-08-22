<?php

namespace App\Exports;

use InvalidArgumentException;
use JsonException;
use SplFileObject;
use SplFileInfo;
use Exception;
use LogicException;

class OriginalJsonExport
{
    private $file;
    private $decoded;
    private $originalFilename;
    private $newFilename;
    private $exportDir;

    public function __construct(string $filename)
    {
        if (is_file($filename) === false) {
            throw new InvalidArgumentException(__CLASS__.' require a valid filename. ['.$filename.'] provided');
        }

        $decoded = json_decode(file_get_contents($filename));

        if (json_last_error() !== JSON_ERROR_NONE) {
            throw new JsonException($filename.' must be a valid json');
        }

        $this->originalFilename = $filename;
        $this->_extract($decoded);
    }

    public function setExportDir($path)
    {
        $dir = new SplFileInfo($path);
        if ($dir->isDir() === false) {
            throw new Exception($path.' is not a valid directory');
        }

        if ($dir->isWritable() === false) {
            throw new Exception($path.' is not a writable directory');
        }

        $this->exportDir = $dir;
    }

    public function save()
    {
        if (($this->exportDir instanceof SplFileInfo) === false) {
            throw new LogicException("You must specify the exportDir first");
        }

        $originalFilename = new SplFileInfo($this->originalFilename);
        $this->newFilename = $originalFilename->getBasename('.'.$originalFilename->getExtension()).'.csv';

        $file = new SplFileObject($this->exportDir.DIRECTORY_SEPARATOR.$this->newFilename, 'w+');

        foreach($this->getDecoded() as $line) {
            $file->fputcsv($line, ";");
        }

        return $file;
    }

    public function getDecoded()
    {
        return $this->decoded;
    }

    private function _extract($decoded)
    {
        $currentCategorie = null;
        $currentCategorieId = 0;

        foreach ($decoded->answers as $categorie) {
            $currentCategorieId = $categorie->id;
            $currentCategorie   = trim($categorie->title);

            foreach ($categorie->group->answers as $question) {
                $typeQuestion = $question->type;

                if ($typeQuestion === 'multiple_choice') {
                    $reponse = implode(',', $question->{$typeQuestion}->choices);
                } elseif ($typeQuestion === 'file_upload') {
                    $reponse = $question->{$typeQuestion}->file_url;
                } else {
                    $reponse = $question->{$typeQuestion}->value;
                }

                $this->decoded[] = [
                    $currentCategorieId,
                    $currentCategorie,
                    $question->id,
                    trim(str_replace("\n", ' ', $question->title)),
                    $typeQuestion,
                    $reponse
                ];
            }
        }
    }
}
