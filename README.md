# zengin-php
The PHP implementation of ZenginCode.

## Installation
Install via [composer](https://getcomposer.org/).

```
$ composer require zengin-code/zengin-php
```

## Usage
```php
// get source data updated at
echo \ZenginCode\ZenginCode::getLastUpdatedAt(); // 20190501

// get all banks as Bank instance array 
$banks = \ZenginCode\ZenginCode::findBank();

// find bank from code as Bank instance
$bank = \ZenginCode\ZenginCode::findBank('0005');
echo $bank->code . PHP_EOL; // 0005
echo $bank->name . PHP_EOL; // 三菱ＵＦＪ
echo $bank->kana . PHP_EOL; // ミツビシユ－エフジエイ
echo $bank->hira . PHP_EOL; // みつびしゆ－えふじえい
echo $bank->roma . PHP_EOL; // mitsubishiyu-efujiei

// get all branches of bank as Branch instance array 
$branches = \ZenginCode\ZenginCode::findBranch();

// find branch from code as Branch instance
$branch = \ZenginCode\ZenginCode::findBranch('0005', '002');
echo $branch->code . PHP_EOL; // 002
echo $branch->name . PHP_EOL; // 丸の内
echo $branch->kana . PHP_EOL; // マルノウチ
echo $branch->hira . PHP_EOL; // まるのうち
echo $branch->roma . PHP_EOL; // marunouchi
```
