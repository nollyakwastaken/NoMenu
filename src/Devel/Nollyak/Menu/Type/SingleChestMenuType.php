<?php

namespace Devel\Nollyak\Menu\Type;

use Devel\Nollyak\Menu\Definition\Type\SingleChestMenuDefinition;

use Devel\Nollyak\Menu\Item\MenuItem;
use Devel\Nollyak\Menu\MenuImpl;

use pocketmine\block\BlockIds;
use pocketmine\level\Position;

use pocketmine\nbt\NBT;
use pocketmine\nbt\tag\CompoundTag;
use pocketmine\nbt\tag\IntTag;
use pocketmine\nbt\tag\StringTag;
use pocketmine\network\mcpe\protocol\BlockEntityDataPacket;
use pocketmine\network\mcpe\protocol\ContainerClosePacket;
use pocketmine\network\mcpe\protocol\ContainerOpenPacket;
use pocketmine\network\mcpe\protocol\UpdateBlockPacket;
use pocketmine\Player;
use pocketmine\scheduler\Task;
use pocketmine\tile\Tile;

final class SingleChestMenuType extends MenuImpl
{

    public function __construct(
        protected Position $position
    )
    {
        parent::__construct($position, new SingleChestMenuDefinition());
    }

    public function renderMenu(Player $player): void
    {
        $packet = new UpdateBlockPacket();

        $position = $this->getMenuHolder()->getPosition();

        $packet->x = $position->getFloorX();
        $packet->y = $position->getFloorY();
        $packet->z = $position->getFloorZ();

        $packet->blockId = BlockIds::CHEST;
        $packet->blockData = 0;

        $packet->flags = UpdateBlockPacket::FLAG_ALL;

        $player->dataPacket($packet);

        $compound = new CompoundTag("", [
            new StringTag("id", Tile::CHEST),
            new StringTag("CustomName", $this->getMenuDefinition()->getSettings()->getName()),
            new IntTag("x", $position->getFloorX()),
            new IntTag("y", $position->getFloorY()),
            new IntTag("z", $position->getFloorZ())
        ]);

        $nbt = new NBT(NBT::LITTLE_ENDIAN);

        $nbt->setData($compound);

        $packet = new BlockEntityDataPacket();

        $packet->x = $position->getFloorX();
        $packet->y = $position->getFloorY();
        $packet->z = $position->getFloorZ();

        $packet->namedtag = $nbt->write(true);

        $player->dataPacket($packet);

        array_map(fn(MenuItem $item) => $this->setItem($item->getSlot(), $item->getIcon()), $this->getMenuDefinition()->getSettings()->getItems());

        $player->getServer()->getScheduler()->scheduleDelayedTask(new class($player, $this) extends Task {

            public function __construct(
                protected Player   $player,
                protected MenuImpl $menu
            )
            {
            }

            public function onRun($currentTick): void
            {
                $packet = new ContainerOpenPacket();

                $packet->windowid = $this->getPlayer()->getWindowId($this->getMenu());
                $packet->type = $this->getMenu()->getType()->getNetworkType();

                $packet->x = $this->getMenu()->getMenuHolder()->getPosition()->getFloorX();
                $packet->y = $this->getMenu()->getMenuHolder()->getPosition()->getFloorY();
                $packet->z = $this->getMenu()->getMenuHolder()->getPosition()->getFloorZ();

                $this->getPlayer()->dataPacket($packet);
                $this->getMenu()->sendContents($this->getPlayer());
            }


            public function getPlayer(): Player
            {
                return $this->player;
            }

            public function getMenu(): MenuImpl
            {
                return $this->menu;
            }

        }, 10);
    }

    public function destroyMenu(Player $player): void
    {
        $packet = new UpdateBlockPacket();

        $packet->x = $this->getMenuHolder()->getPosition()->getFloorX();
        $packet->y = $this->getMenuHolder()->getPosition()->getFloorY();
        $packet->z = $this->getMenuHolder()->getPosition()->getFloorZ();

        $packet->blockId = $this->getMenuHolder()
            ->getPosition()
            ->getLevel()
            ->getBlockIdAt($this->getMenuHolder()->getPosition()->getFloorX(), $this->getMenuHolder()->getPosition()->getFloorY(), $this->getMenuHolder()->getPosition()->getFloorZ());

        $packet->blockData = $this->getMenuHolder()
            ->getPosition()
            ->getLevel()
            ->getBlockDataAt($this->getMenuHolder()->getPosition()->getFloorX(), $this->getMenuHolder()->getPosition()->getFloorY(), $this->getMenuHolder()->getPosition()->getFloorZ());

        $packet->flags = UpdateBlockPacket::FLAG_ALL;

        $player->dataPacket($packet);

        $player->getServer()->getScheduler()->scheduleDelayedTask(new class($player, $this) extends Task {

            public function __construct(
                protected Player   $player,
                protected MenuImpl $menu
            )
            {
            }

            public function onRun($currentTick): void
            {
                $packet = new ContainerClosePacket();

                $packet->windowid = $this->getPlayer()->getWindowId($this->getMenu());

                $this->getPlayer()->dataPacket($packet);
            }

            public function getPlayer(): Player
            {
                return $this->player;
            }

            public function getMenu(): MenuImpl
            {
                return $this->menu;
            }

        }, 10);
    }

}