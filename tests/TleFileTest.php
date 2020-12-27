<?php

use Ivanstan\Tle\Model\TleFile;
use PHPUnit\Framework\TestCase;

class TleFileTest extends TestCase
{
    private TleFile $file;

    public function setUp(): void
    {
        $this->file = new TleFile(file_get_contents('./tests/data/tle.txt'));
        parent::setUp();
    }

    public function testFileRead(): void
    {
        $tle = $this->file->parse();

        static::assertEquals('LUCAS (JDRS-1)', $tle[0]->getName());
    }
}