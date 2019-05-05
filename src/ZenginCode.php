<?php
namespace ZenginCode;

use ZenginCode\Model\Bank;
use ZenginCode\Model\Branch;

class ZenginCode
{
    protected static $_version = null;
    protected static $_banks = [];
    protected static $_branches = [];

    const DATA_PATH = __DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'source-data' . DIRECTORY_SEPARATOR . 'data';
    const DIGIT_BANK_CODE = 4;
    const DIGIT_BRANCH_CODE = 3;

    /**
     * get Last Updated date.
     *
     * @return string updated_at (YYYYMMDD style)
     */
    public static function getLastUpdatedAt()
    {
        if(!static::$_version) {
            static::$_version = file_get_contents(ZenginCode::DATA_PATH . DIRECTORY_SEPARATOR . 'updated_at');
        }

        return static::$_version;
    }

    /**
     * load source file
     * NOTICE: USE ONLY INTERNAL CALL (this method not verify path)
     *
     * @param $path
     * @return array
     */
    protected static function loadSourceFile($path)
    {
        if(!is_file(static::DATA_PATH . DIRECTORY_SEPARATOR . $path)) {
            return null;
        }

        $fileContent = file_get_contents(static::DATA_PATH . DIRECTORY_SEPARATOR . $path);
        return $fileContent !== false ? \GuzzleHttp\json_decode($fileContent, true) : null;
    }

    protected static function normalizeCode($rawCode, $digit)
    {
        return is_int($rawCode) ? sprintf('%0' . $digit . 'd', $rawCode) : (string)$rawCode;
    }

    /**
     * find bank instance of specified code.
     *
     * if you not specified bank code, return all bank instances
     *
     * @param null $bankCode
     * @return null|Bank|Bank[]
     */
    public static function findBank($bankCode = null)
    {
        if(!static::$_banks) {
            $jsonBanks = static::loadSourceFile('banks.json');
            foreach ($jsonBanks as $jsonBank) {
                static::$_banks[$jsonBank['code']] = new Bank($jsonBank);
            }
        }

        if($bankCode === null) {
            return static::$_banks;
        }

        $bankCode = static::normalizeCode($bankCode, static::DIGIT_BANK_CODE);

        return isset(static::$_banks[$bankCode]) ? static::$_banks[$bankCode] : null;
    }

    public static function findBranch($bankCode, $branchCode = null)
    {
        $bankCode = static::normalizeCode($bankCode, static::DIGIT_BANK_CODE);

        if(!isset(static::$_branches[$bankCode])) {
            $jsonBranches = static::loadSourceFile('branches' . DIRECTORY_SEPARATOR . $bankCode . '.json');
            if($jsonBranches) {
                $branches = [];
                foreach ($jsonBranches as $jsonBranch) {
                    $branches[$jsonBranch['code']] = new Branch($jsonBranch);
                }

                static::$_branches[$bankCode] = $branches;
            }
        }

        if($branchCode === null) {
            return static::$_branches[$bankCode];
        }

        $branchCode = static::normalizeCode($branchCode, static::DIGIT_BRANCH_CODE);

        return isset(static::$_branches[$bankCode][$branchCode]) ? static::$_branches[$bankCode][$branchCode] : null;
    }
}
