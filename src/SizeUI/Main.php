<?php

namespace SizeUI;

use pocketmine\plugin\PluginBase;

use pocketmine\event\Listener;

use pocketmine\Player;
use pocketmine\Server;

use pocketmine\command\CommandSender;
use pocketmine\command\Command;

use pocketmine\utils\TextFormat as C;

use SizeUI\Main;

class Main extends PluginBase implements Listener {

	public function onEnable(){
		$this->getServer()->getPluginManager()->registerEvents($this, $this);
		$this->getLogger()->info(C::GREEN . "Plugin SizeUI Enabled!");
	}

	public function onDisable(){
		$this->getLogger()->info(C::RED . "Plugin SizeUI Disabled!");
	}

	public function onCommand(CommandSender $player, Command $command, string $label, array $args) : bool {
		switch($command->getName()){
			case "sizeui":
			if($player instanceof Player){
			    $this->openMyForm($player);
			} else {
				$player->sendMessage("You can use this command only in-game.");
					return true;
			}
			break;
		}
	    return true;
	}

	public function openMyForm(Player $player){
		$formapi = $this->getServer()->getPluginManager()->getPlugin("FormAPI");
		$form = $formapi->createSimpleForm(function (Player $player, int $data = null){
		$result = $data;
		if($result === null){
			return;
		    }
			switch($result){
				case 0;
					$player->setScale(0.5);
				    $player->sendMessage(C::GREEN . "Your size has been changed to Small.");
					return;
				break;
                case 1;
					 $player->setScale(3);
				     $player->sendMessage(C::GREEN . "Your size has been changed to Big.");
					 return;
				break;
				case 2;
					 $player->setScale(1);
				     $player->sendMessage(C::GREEN . "Your size has been changed to Default.");
					 return;
				break;
				case 3;
					  $this->onCustomForm($player);
					  return;
				break;
			}
			});
			$form->setTitle(C::BOLD . "SIZEUI");
			$form->setContent("Change your size:");
			$form->addButton("Small");
			$form->addButton("Big");
			$form->addButton("Default");
			$form->addButton("Custom");
			$form->sendToPlayer($player);
			return $form;
	}
	
	public function onCustomForm(Player $player){
		$formapi = $this->getServer()->getPluginManager()->getPlugin("FormAPI");
		$form = $formapi->createCustomForm(function (Player $player, $data){
		$result = $data[0];
        if($data !== null){
		    $player->setScale($result);
			$player->sendMessage(C::GREEN . "Your size has been changed to Custom.");
            }
        });
        $form->setTitle(C::BOLD . "SIZEUI");
		$form->addInput("Custom Size:");
        $form->sendToPlayer($player);
	}
}