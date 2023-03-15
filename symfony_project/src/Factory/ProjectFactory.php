<?php

namespace App\Factory;

use App\Entity\Project;
use Zenstruck\Foundry\RepositoryProxy;
use Zenstruck\Foundry\ModelFactory;
use Zenstruck\Foundry\Proxy;

/**
 * @extends ModelFactory<Project>
 *
 * @method static Project|Proxy createOne(array $attributes = [])
 * @method static Project[]|Proxy[] createMany(int $number, array|callable $attributes = [])
 * @method static Project|Proxy find(object|array|mixed $criteria)
 * @method static Project|Proxy findOrCreate(array $attributes)
 * @method static Project|Proxy first(string $sortedField = 'id')
 * @method static Project|Proxy last(string $sortedField = 'id')
 * @method static Project|Proxy random(array $attributes = [])
 * @method static Project|Proxy randomOrCreate(array $attributes = [])
 * @method static Project[]|Proxy[] all()
 * @method static Project[]|Proxy[] findBy(array $attributes)
 * @method static Project[]|Proxy[] randomSet(int $number, array $attributes = [])
 * @method static Project[]|Proxy[] randomRange(int $min, int $max, array $attributes = [])
 * @method Project|Proxy create(array|callable $attributes = [])
 */
final class ProjectFactory extends ModelFactory
{

    public function __construct()
    {
        parent::__construct();
    }

    protected function getDefaults(): array
    {
        return [
            'name' => self::faker()->name,
            'owner' => UserFactory::random()
        ];
    }

    protected function initialize(): self
    {
        return $this;
    }

    protected static function getClass(): string
    {
        return Project::class;
    }
}