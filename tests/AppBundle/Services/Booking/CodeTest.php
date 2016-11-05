<?php

namespace Tests\AppBundle\Booking;

use AppBundle\Services\Booking\Code;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class CodeTest extends WebTestCase
{
    private $em;

    public function __construct()
    {
        $kernelNameClass = $this->getKernelClass();
        $kernel = new $kernelNameClass('test', true);
        $kernel->boot();
        $this->em = $kernel->getContainer()->get('doctrine.orm.entity_manager');
    }

    public function testGenerateCode()
    {
        $code = new Code($this->em);

        $codeGenerated = $code->generateCode();

        $this->assertRegExp('/BC\-[a-zA-Z0-9]+/', $codeGenerated);
    }
}