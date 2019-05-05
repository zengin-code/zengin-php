<?php
namespace ZenginCode;

use PHPUnit\Framework\TestCase;

class ZenginCodeTest extends TestCase
{
    public function test_getLastUpdatedAt()
    {
        $this->assertSame(
            file_get_contents(ZenginCode::DATA_PATH . DIRECTORY_SEPARATOR . 'updated_at'),
            ZenginCode::getLastUpdatedAt()
        );
    }

    public function test_findBank_existsCode()
    {
        $actualBank = ZenginCode::findBank('0001');

        $this->assertSame('0001', $actualBank->code);
        $this->assertSame('みずほ', $actualBank->name);
        $this->assertSame('ミズホ', $actualBank->kana);
        $this->assertSame('みずほ', $actualBank->hira);
        $this->assertSame('mizuho', $actualBank->roma);
    }

    public function test_findBank_notExistsCode()
    {
        $this->assertNull(ZenginCode::findBank('9999'));
    }

    public function test_findBank_intCode()
    {
        $actualBank = ZenginCode::findBank(125);

        $this->assertSame('0125', $actualBank->code);
        $this->assertSame('七十七', $actualBank->name);
        $this->assertSame('シチジユウシチ', $actualBank->kana);
        $this->assertSame('しちじゆうしち', $actualBank->hira);
        $this->assertSame('shichijiyuushichi', $actualBank->roma);
    }

    public function test_findBank_all()
    {
        $banks = ZenginCode::findBank();

        $this->assertIsArray($banks);
        foreach ($banks as $bank) {
            $this->assertInstanceOf('ZenginCode\Model\Bank', $bank);
        }
   }

   public function test_findBranch_existsCode()
   {
       $actualBranch = ZenginCode::findBranch('0001', '001');
       $this->assertSame('001', $actualBranch->code);
       $this->assertSame('東京営業部', $actualBranch->name);
       $this->assertSame('トウキヨウ', $actualBranch->kana);
       $this->assertSame('とうきよう', $actualBranch->hira);
       $this->assertSame('toukiyou', $actualBranch->roma);
   }

    /**
     * @depends test_findBranch_existsCode
     */
    public function test_findBranch_anotherExistsCode()
    {
        $actualBranch = ZenginCode::findBranch('0005', '001');
        $this->assertSame('001', $actualBranch->code);
        $this->assertSame('本店', $actualBranch->name);
        $this->assertSame('ホンテン', $actualBranch->kana);
        $this->assertSame('ほんてん', $actualBranch->hira);
        $this->assertSame('honten', $actualBranch->roma);
    }

    /**
     * @depends test_findBranch_anotherExistsCode
     */
    public function test_findBranch_recallFirstExitsCode()
    {
        $actualBranch = ZenginCode::findBranch('0001', '001');
        $this->assertSame('001', $actualBranch->code);
        $this->assertSame('東京営業部', $actualBranch->name);
        $this->assertSame('トウキヨウ', $actualBranch->kana);
        $this->assertSame('とうきよう', $actualBranch->hira);
        $this->assertSame('toukiyou', $actualBranch->roma);
    }

    public function test_findBranch_notExistsCode()
    {
        $this->assertNull(ZenginCode::findBranch('0001', '999'));
    }

    public function test_findBranch_notExistsBank()
    {
        try {
            $this->assertNull(ZenginCode::findBranch('9999', '001'));
        } catch (\Throwable $t) {
            $this->fail();
        }
    }

    public function test_findBranch_all()
    {
        $branches = ZenginCode::findBranch('0001');

        $this->assertIsArray($branches);
        foreach ($branches as $branch) {
            $this->assertInstanceOf('ZenginCode\Model\Branch', $branch);
        }
    }

}
