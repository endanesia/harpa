<?php

if (!defined('BASEPATH')) exit('No direct script access allowed');

// Load PhpSpreadsheet via Composer autoloader
require_once FCPATH . 'vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Cell\Coordinate;

/**
 * Excel library wrapper for CodeIgniter 3
 * Migrated from PHPExcel to PhpSpreadsheet for PHP 8.2+ compatibility
 */
class Excel extends Spreadsheet {
    public function __construct() {
        parent::__construct();
    }
}

/**
 * Wrapper for PhpSpreadsheet Worksheet to provide PHPExcel 0-based column compatibility
 */
class PHPExcel_Worksheet_Compat {
    protected $worksheet;

    public function __construct($worksheet) {
        $this->worksheet = $worksheet;
    }

    /**
     * PHPExcel uses 0-based column index, PhpSpreadsheet uses 1-based
     * This wrapper adds +1 to maintain backward compatibility
     */
    public function getCellByColumnAndRow($col, $row) {
        return $this->worksheet->getCellByColumnAndRow($col + 1, $row);
    }

    public function __call($name, $arguments) {
        return call_user_func_array(array($this->worksheet, $name), $arguments);
    }

    public function __get($name) {
        return $this->worksheet->$name;
    }
}

/**
 * Wrapper for PhpSpreadsheet object to return compatible worksheets
 */
class PHPExcel_Spreadsheet_Compat {
    protected $spreadsheet;

    public function __construct($spreadsheet) {
        $this->spreadsheet = $spreadsheet;
    }

    public function getSheet($index) {
        return new PHPExcel_Worksheet_Compat($this->spreadsheet->getSheet($index));
    }

    public function getWorksheetIterator() {
        $sheets = array();
        foreach ($this->spreadsheet->getWorksheetIterator() as $worksheet) {
            $sheets[] = new PHPExcel_Worksheet_Compat($worksheet);
        }
        return $sheets;
    }

    public function __call($name, $arguments) {
        return call_user_func_array(array($this->spreadsheet, $name), $arguments);
    }

    public function __get($name) {
        return $this->spreadsheet->$name;
    }
}

/**
 * Backward-compatible aliases for old PHPExcel classes
 */
if (!class_exists('PHPExcel_IOFactory')) {
    class PHPExcel_IOFactory {
        public static function load($filename) {
            $spreadsheet = IOFactory::load($filename);
            return new PHPExcel_Spreadsheet_Compat($spreadsheet);
        }
        public static function createReader($readerType) {
            return IOFactory::createReader($readerType);
        }
        public static function createWriter($spreadsheet, $writerType) {
            return IOFactory::createWriter($spreadsheet, $writerType);
        }
    }
}

if (!class_exists('PHPExcel_Cell')) {
    class PHPExcel_Cell {
        /**
         * PHPExcel returns 1-based (A=1), PhpSpreadsheet also returns 1-based. Compatible.
         */
        public static function columnIndexFromString($pString) {
            return Coordinate::columnIndexFromString($pString);
        }
        /**
         * PHPExcel uses 0-based (0=A), PhpSpreadsheet uses 1-based (1=A). Add +1 for compat.
         */
        public static function stringFromColumnIndex($columnIndex) {
            return Coordinate::stringFromColumnIndex($columnIndex + 1);
        }
    }
}
?>