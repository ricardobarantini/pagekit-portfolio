<?php

namespace Pagekit\Portfolio\Model;

use Pagekit\Application as App;
use Pagekit\System\Model\DataModelTrait;

/**
 * @Entity(tableClass="@portfolio_project")
 */
class Project implements \JsonSerializable
{
    use  DataModelTrait, ProjectModelTrait;

    /** @Column(type="integer") @Id */
    public $id;

    /** @Column(type="integer") */
    public $priority;

    /** @Column(type="string") */
    public $title;

    /** @Column(type="string") */
    public $slug;

	/** @Column(type="string") */
	public $subtitle;

	/** @Column(type="text") */
	public $intro = '';

	/** @Column(type="text") */
    public $content = '';

	/** @Column(type="datetime") */
	public $date;

	/** @Column(type="simple_array") */
	public $tags;

	/** @Column(type="json_array") */
	public $images;


    /**
     * {@inheritdoc}
     */
    public function jsonSerialize()
    {
        $data = [
            'url' => App::url('@portfolio/id', ['id' => $this->id ?: 0], 'base')
        ];

        return $this->toArray($data);
    }
}