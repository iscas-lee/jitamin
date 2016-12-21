<?php

/*
 * This file is part of Hiject.
 *
 * Copyright (C) 2016 Hiject Team
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

use Hiject\Model\ProjectModel;
use Hiject\Model\TagDuplicationModel;
use Hiject\Model\TagModel;

require_once __DIR__.'/../Base.php';

class TagDuplicationModelTest extends Base
{
    public function testProjectDuplication()
    {
        $tagModel = new TagModel($this->container);
        $tagDuplicationModel = new TagDuplicationModel($this->container);
        $projectModel = new ProjectModel($this->container);

        $this->assertEquals(1, $projectModel->create(['name' => 'P1']));
        $this->assertEquals(2, $projectModel->create(['name' => 'P2']));

        $this->assertEquals(1, $tagModel->create(0, 'Tag 1'));
        $this->assertEquals(2, $tagModel->create(1, 'Tag 2'));
        $this->assertEquals(3, $tagModel->create(1, 'Tag 3'));

        $this->assertTrue($tagDuplicationModel->duplicate(1, 2));

        $tags = $tagModel->getAllByProject(2);
        $this->assertCount(2, $tags);
        $this->assertEquals('Tag 2', $tags[0]['name']);
        $this->assertEquals('Tag 3', $tags[1]['name']);
    }
}