<?php

declare(strict_types=1);

use Atomastic\Arrays\Arrays;

test('test filterCollection() method', function () {
    $this->assertEquals([], filterCollection());
    $this->assertEquals([], filterCollection([]));
    $this->assertEquals([], filterCollection([], []));
    $this->assertEquals(['foo', 'bar'], filterCollection(['foo', 'bar'], []));

    $data = ['home'  => ['title' => 'Home'],
             'about' => ['title' => 'About'],
             'blog'  => ['title' => 'Blog']];

    // return: first
    $this->assertEquals(['title' => 'Home'], filterCollection($data, ['return' => 'first']));

    // return: last
    $this->assertEquals(['title' => 'Blog'], filterCollection($data, ['return' => 'last']));

    // return: next
    $this->assertEquals(['title' => 'About'], filterCollection($data, ['return' => 'next']));

    // return: random
    $random = filterCollection($data, ['return' => 'random']);
    $this->assertContains($random, $data);

    $random = filterCollection($data, ['return' => 'random', 'random' => 0]);
    $this->assertIsArray($random);
    $this->assertCount(0, $random);

    $random = filterCollection($data, ['return' => 'random', 'random' => 1]);
    $this->assertIsArray($random);
    $this->assertCount(1, $random);
    $this->assertContains(filterCollection($data, ['return' => 'first']), $data);

    $random = filterCollection($data, ['return' => 'random', 'random' => 2]);
    $this->assertIsArray($random);
    $this->assertCount(2, $random);
    $this->assertContains(filterCollection($random, ['return' => 'first']), $data);
    $this->assertContains(filterCollection($random, ['return' => 'last']), $data);

    // return: shuffle
    $this->assertTrue(
        is_array(filterCollection($data, ['return' => 'shuffle'])) &&
        is_array(filterCollection($data, ['return' => 'shuffle']))
    );

    // param: offset and return: all
    $this->assertEquals(['about' => ['title' => 'About'],
                         'blog'  => ['title' => 'Blog']], filterCollection($data, ['return' => 'all', 'offset' => 1]));

    // param: limit and return: all
    $this->assertEquals(['home'  => ['title' => 'Home']], filterCollection($data, ['return' => 'all', 'limit' => 1]));

    // param: sort_by and return: all
    $this->assertEquals(['about' => ['title' => 'About'],
                         'blog'  => ['title' => 'Blog'],
                         'home'  => ['title' => 'Home']],
                            filterCollection($data, ['return' => 'all',
                                                   'sort_by' => ['key' => 'title',
                                                                 'direction' => 'ASC']]));

    $this->assertEquals(['home'  => ['title' => 'Home'],
                         'blog'  => ['title' => 'Blog'],
                         'about' => ['title' => 'About']],
                            filterCollection($data, ['return' => 'all',
                                                   'sort_by' => ['key' => 'title',
                                                                 'direction' => 'DESC']]));

     $this->assertEquals(['Home' => [0 => ['title' => 'Home']],
                          'About' => [0 => ['title' => 'About']],
                          'Blog' => [0 => ['title' => 'Blog']]],
                             filterCollection($data, ['return' => 'all',
                                                    'group_by' => 'title']));
    // param: where and return: all
    $this->assertEquals(['about' => ['title' => 'About']],
                        filterCollection($data, ['return' => 'all',
                                               'where' => [['key' => 'title', 'operator' => '=', 'value' => 'About']]]));
});
