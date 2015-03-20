<?php
namespace Themosis\Field\Fields;

use Themosis\Facades\View;

class ReferenceField extends FieldBuilder{

    /**
     * Define a core TextField.
     *
     * @param array $properties The text field properties.
     */
    public function __construct(array $properties)
    {
        parent::__construct($properties);

        $this->fieldType();
    }

    /**
     * Method to override to define the input type
     * that handles the value.
     *
     * @return void
     */
    protected function fieldType()
    {
        $this->type = 'reference';
    }

    /**
     * Handle the field HTML code for metabox output.
     *
     * @return string
     */
    public function metabox()
    {
        $this['options'] = array();
        $posts = get_posts(array('post_type'=>$this['type']));
        $opts = array();
        foreach($posts as $post)
        {
            $opts[$post->ID]=$post->post_title;
        }
        $this['options']=array($opts);
        return View::make('metabox._themosisReferenceField', array('field' => $this))->render();
    }

    /**
     * Handle the field HTML code for the Settings API output.
     *
     * @return string
     */
    public function page()
    {
        return $this->metabox();
    }

}