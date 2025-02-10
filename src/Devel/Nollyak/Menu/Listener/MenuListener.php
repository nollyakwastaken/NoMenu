<?php

namespace Devel\Nollyak\Menu\Listener;

use Devel\Nollyak\Menu\MenuImpl;
use Devel\Nollyak\Menu\Type\HopperMenuType;
use Devel\Nollyak\NoMenu;
use pocketmine\event\inventory\InventoryTransactionEvent;
use pocketmine\event\Listener;
use pocketmine\event\player\PlayerJoinEvent;
use pocketmine\inventory\BaseTransaction;
use pocketmine\inventory\DropItemTransaction;
use pocketmine\inventory\Transaction;
use pocketmine\Player;

final class MenuListener implements Listener
{

    public function __construct(
        protected NoMenu $plugin
    )
    {
    }

    public function onJoin(
        PlayerJoinEvent $event
    ): void
    {
        $player = $event->getPlayer();

        $menu = new HopperMenuType($player->getPosition());

        $player->addWindow($menu);
    }

    public function onTransaction(
        InventoryTransactionEvent $event
    ): void
    {
        $queue = $event->getQueue();
        $transactions = $queue->getTransactions();
        foreach ($transactions as $transaction) {
            if ($transaction instanceof Transaction) {
                $inventory = $transaction->getInventory();
                if ($inventory instanceof MenuImpl) {
                    array_map(function (Player $player) use ($inventory, $event, $transaction) {
                        if ($transaction instanceof BaseTransaction) {
                            $event->setCancelled();
                            if ($inventory->getMenuDefinition()->getSettings()->hasMenuItem($transaction->getSlot()))
                                call_user_func($inventory->getMenuDefinition()->getSettings()->getMenuItem($transaction->getSlot())->onClick(), $player);
                        }
                        if ($transaction instanceof DropItemTransaction)
                            $event->setCancelled();
                    }, $inventory->getViewers());
                }
            }
        }
    }

    public function getPlugin(): NoMenu
    {
        return $this->plugin;
    }

}