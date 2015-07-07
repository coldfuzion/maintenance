<?php

namespace Stevebauman\Maintenance\Models;

use Baum\Node;

class Location extends Node
{
    /**
     * The locations table.
     *
     * @var string
     */
    protected $table = 'locations';

    /**
     * The fillable location attributes.
     *
     * @var array
     */
    protected $fillable = [
        'name',
    ];

    /**
     * The revision formatted field name attributes.
     *
     * @var array
     */
    protected $revisionFormattedFieldNames = [
        'name' => 'Name',
    ];

    /**
     * Returns a single lined string with arrows indicating depth of the current category.
     *
     * @return string
     */
    public function getTrailAttribute()
    {
        return renderNode($this);
    }

    /**
     * Compatibility with Revisionable.
     *
     * @return string
     */
    public function identifiableName()
    {
        return $this->getTrailAttribute();
    }
}