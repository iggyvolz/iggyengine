<?php

use iggyvolz\iggyengine\GameObject;
use iggyvolz\iggyengine\Stage;
use iggyvolz\SFML\Audio\Music;
use iggyvolz\SFML\Graphics\Font;
use iggyvolz\SFML\Graphics\Sprite;
use iggyvolz\SFML\Graphics\Text;
use iggyvolz\SFML\Graphics\Texture;
use iggyvolz\SFML\Sfml;
use iggyvolz\SFML\System\Vector\Vector2F;
use iggyvolz\SFML\System\Vector\Vector2U;

require_once __DIR__ . "/vendor/autoload.php";
$sfml = new Sfml(
    __DIR__ . "/../CSFML/lib/libcsfml-audio.so",
    __DIR__ . "/../CSFML/lib/libcsfml-graphics.so",
    __DIR__ . "/../CSFML/lib/libcsfml-network.so",
    __DIR__ . "/../CSFML/lib/libcsfml-system.so",
    __DIR__ . "/../CSFML/lib/libcsfml-window.so",
);
$stage = Stage::createWindow($sfml, "SFML window");
$stage->target->setSize(Vector2U::create($sfml, 960, 540));
$texture = Texture::createFromFile($sfml, __DIR__ . "/../phpsfml_/demo/cute_image.jpg") ?? throw new RuntimeException();
$sprite = Sprite::create($sfml) ?? throw new RuntimeException();
$sprite->setScale(Vector2F::create($sfml, 0.5, 0.5));
$sprite->setTexture($texture, true);
$gameObject = new GameObject($sprite, $stage, 10);
$font = Font::createFromFile($sfml, __DIR__ . "/../phpsfml_/demo/arial.ttf") ?? throw new RuntimeException();
$text = Text::create($sfml) ?? throw new RuntimeException();
$text->setString("Hello SFML");
$text->setFont($font);
$text->setCharacterSize(50);
$textObjet = new GameObject($text, $stage, 0);
$music = Music::createFromFile($sfml, __DIR__ . "/../phpsfml_/demo/nice_music.ogg") ?? throw new RuntimeException();
$music->setVolume(0.1);
$music->play();
$stage->run();
//while($window->isOpen()) {
//    if($event = $window->pollEvent()) {
//        if($event instanceof ClosedEvent) {
//            $window->close();
//        }
//    }
//    $window->clear();
//    $window->draw($sprite);
//    $window->draw($text);
//    $window->display();
//}
