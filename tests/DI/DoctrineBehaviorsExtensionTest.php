<?php

declare(strict_types=1);

namespace Zenify\DoctrineBehaviors\Tests\DI;

use Doctrine\ORM\EntityManager;
use Knp\DoctrineBehaviors\ORM\Blameable\BlameableSubscriber;
use Knp\DoctrineBehaviors\ORM\Geocodable\GeocodableSubscriber;
use Knp\DoctrineBehaviors\ORM\Loggable\LoggableSubscriber;
use Knp\DoctrineBehaviors\ORM\Sluggable\SluggableSubscriber;
use Knp\DoctrineBehaviors\ORM\SoftDeletable\SoftDeletableSubscriber;
use Knp\DoctrineBehaviors\ORM\Timestampable\TimestampableSubscriber;
use Knp\DoctrineBehaviors\ORM\Translatable\TranslatableSubscriber;
use Knp\DoctrineBehaviors\ORM\Tree\TreeSubscriber;
use Nette\DI\Container;
use PHPUnit\Framework\TestCase;
use Zenify;
use Zenify\DoctrineBehaviors\Tests\ContainerFactory;


final class DoctrineBehaviorsExtensionTest extends TestCase
{

	/**
	 * @var int
	 */
	const LISTENER_COUNT = 20;

	/**
	 * @var string[]
	 */
	private $listeners = [
		BlameableSubscriber::class,
		GeocodableSubscriber::class,
		LoggableSubscriber::class,
		SluggableSubscriber::class,
		SoftDeletableSubscriber::class,
		TimestampableSubscriber::class,
		TranslatableSubscriber::class,
		TreeSubscriber::class,
	];


	public function testExtensions()
	{
		$container = (new ContainerFactory)->create();

		/** @var EntityManager $entityManager */
		$entityManager = $container->getByType(EntityManager::class);
		$this->assertInstanceOf(EntityManager::class, $entityManager);

		$count = 0;
		foreach ($entityManager->getEventManager()->getListeners() as $listenerSet) {
			foreach ($listenerSet as $listener) {
				$this->assertContains(get_class($listener), $this->listeners);
				$count++;
			}
		}

		$this->assertEquals(self::LISTENER_COUNT, $count);
	}

}
