<?php declare(strict_types=1);

namespace Shopware\Core\Content\Media\Pathname\PathnameStrategy;

use Shopware\Core\Content\Media\Exception\EmptyMediaFilenameException;
use Shopware\Core\Content\Media\Exception\EmptyMediaIdException;

class Md5PathnameStrategy implements PathnameStrategyInterface
{
    /**
     * @var array
     */
    private $blacklist = [
        'ad' => 'g0',
    ];

    /**
     * @var PlainPathnameStrategy
     */
    private $plainPathnameStrategy;

    public function __construct(PlainPathnameStrategy $plainPathnameStrategy)
    {
        $this->plainPathnameStrategy = $plainPathnameStrategy;
    }

    public function encode(string $filename, string $id): string
    {
        if (empty($filename)) {
            throw new EmptyMediaFilenameException();
        }

        if (empty($id)) {
            throw new EmptyMediaIdException();
        }

        $md5hash = md5($filename);

        $md5hashSlices = \array_slice(str_split($md5hash, 2), 0, 3);
        $md5hashSlices = array_map(
            function ($slice) {
                return array_key_exists($slice, $this->blacklist) ? $this->blacklist[$slice] : $slice;
            },
            $md5hashSlices
        );

        return implode('/', $md5hashSlices)
            . '/'
            . $this->plainPathnameStrategy->encode($filename, $id);
    }

    public function getName(): string
    {
        return 'md5';
    }
}
