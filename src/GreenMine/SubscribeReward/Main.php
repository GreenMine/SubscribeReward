<?php

declare(strict_types=1);

namespace GreenMine\SubscribeReward;

use pocketmine\event\Listener;
use pocketmine\event\player\PlayerJoinEvent;
use pocketmine\item\Item;
use pocketmine\plugin\PluginBase;
use pocketmine\command\CommandSender;
use pocketmine\command\Command;
use GreenMine\VKBinding\Loader;
use pocketmine\utils\Config;

class Main extends PluginBase implements Listener {

	public function onEnable() : void{
        $this->saveResource('config.json');
	    $this->cfg = new Config($this->getDataFolder() . 'config.json', CONFIG::JSON);
	    $this->getServer()->getPluginManager()->registerEvents($this, $this);
		$this->getLogger()->info("Load reward for subscribe");
	}

	public function join(PlayerJoinEvent $event) {
	    $player = $event->getPlayer();
        $name = $player->getName();
	    $api = Loader::getInstance();
	    $api->setPlayer($name);
	    if($api->isSubscribe()) {
	        if($this->cfg->exists($name)) {
                $player->getInventory()->addItem(Item::get(322, 0, 64));
                $this->cfg->set($name, 1);
            }
        }
    }

	public function onDisable() : void{
		$this->getLogger()->info("Unload reward for subscribe");
	}
}
