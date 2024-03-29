<?php

namespace App\Factory;

use App\Factory\ProjectFactory;

use App\Entity\File;
use Zenstruck\Foundry\RepositoryProxy;
use Zenstruck\Foundry\ModelFactory;
use Zenstruck\Foundry\Proxy;

/**
 * @extends ModelFactory<File>
 *
 * @method static File|Proxy createOne(array $attributes = [])
 * @method static File[]|Proxy[] createMany(int $number, array|callable $attributes = [])
 * @method static File|Proxy find(object|array|mixed $criteria)
 * @method static File|Proxy findOrCreate(array $attributes)
 * @method static File|Proxy first(string $sortedField = 'id')
 * @method static File|Proxy last(string $sortedField = 'id')
 * @method static File|Proxy random(array $attributes = [])
 * @method static File|Proxy randomOrCreate(array $attributes = [])
 * @method static File[]|Proxy[] all()
 * @method static File[]|Proxy[] findBy(array $attributes)
 * @method static File[]|Proxy[] randomSet(int $number, array $attributes = [])
 * @method static File[]|Proxy[] randomRange(int $min, int $max, array $attributes = [])
 * @method File|Proxy create(array|callable $attributes = [])
 */
final class FileFactory extends ModelFactory
{

    public function __construct()
    {
        parent::__construct();
    }

    protected function getDefaults(): array
    {
        return [
            'name' => self::faker()->name,
            'project' => ProjectFactory::random(),
            'size' => self::faker()->randomDigit(),
            'created_at' => self::faker()->dateTimeBetween('-10 days'),
        ];
    }

    protected function initialize(): self
    {
        return $this;
    }

    protected static function getClass(): string
    {
        return File::class;
    }
}