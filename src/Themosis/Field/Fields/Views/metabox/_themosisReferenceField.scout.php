<?php

    //var_dump($field);
    $json_query = str_replace('"',"'",json_encode($field['query']));
    if(!isset($field['limit'])) $field['limit']=0;
    //var_dump($json_params);
?>

<!-- Collection field -->
<div class="themosis-collection-wrapper rows" data-custom-select="true" data-type-name="{{$field['type-name']?$field['type-name']:get_post_type_object($field['type'])->labels->singular_name}}"
     data-type="{{ $field['type'] }}" data-limit="{{ $field['limit'] }}" data-order="1"
     data-query="{{ $json_query }}"
     data-name="{{ $field['name'] }}[]" data-field="collection">

    <script class="themosis-collection-selector-template" type="text/template">
    @if(isset($field['selectorTemplate']))
        {{$field['selectorTemplate']}}
    @else
        <div class="selector"><h1><%=title%></h1>
            <a class="media-modal-close" href="#"><span class="media-modal-icon"><span class="screen-reader-text">Zavřít okno pro práci s mediálními soubory</span></span></a>
            <div class="data"></div>
        </div>
    @endif
    </script>

    <script class="themosis-collection-selector-item-template" type="text/template">
    @if(isset($field['selectorItemTemplate']))
        {{$field['selectorItemTemplate']}}
    @else
        <li data-mfcc-id="<%= ID %>" data-mfcc-title="<%= post_title %>">
            <span><%= post_title %></span>
        </li>
    @endif
    </script>

    <script id="themosis-collection-item-template" type="text/template">
        <input type="hidden" name="{{ $field['name'] }}[]" value="<%= value %>" data-field="collection"/>
        <div class="themosis-collection__item">
    @if(isset($field['itemTemplate']))
            @include($field['itemTemplate'],['_language'=>'javascript'])
    @else
            <div class="name">
                <div><%= title %></div>
            </div>

    @endif
            <a class="check" title="Remove" href="#">
                <div class="media-modal-icon"></div>
            </a>
        </div>
    </script>


    <?php
    $show = empty($field['value']) ? '' : 'show';
    ?>
    <div class="themosis-collection-container {{ $show }}">
        <!-- Collection -->
        <div class="themosis-collection">
            <ul class="themosis-collection-list">
                @if (!empty($field['value']) && is_array($field['value']))
                @foreach($field['value'] as $i => $item)
                <li>
                    {{ Themosis\Facades\Form::hidden($field['name'].'[]', $item, array('data-field' => 'collection', 'data-limit' => 10)) }}
                    <div class="themosis-collection__item">

                        @if(isset($field['itemTemplate']))
                            @include($field['itemTemplate'],['_language'=>'php','i'=>$i,'item'=>$item])
                        @else
                        <div class="name">
                            <div>{{get_the_title($item)}}</div>
                        </div>

                        @endif

                        <a class="check" title="Remove" href="#">
                            <div class="media-modal-icon"></div>
                        </a>
                        <a class="edit" href="{{get_edit_post_link( $item,'' )}}">edit..</a>
                    </div>
                </li>
                @endforeach
                @endif
            </ul>
        </div>
        <!-- End collection -->
    </div>
    <div class="themosis-collection-buttons">
        <button id="themosis-collection-add" type="button" class="button button-primary{{($field['limit']&&sizeof($field['value'])>=$field['limit'])?' hide':''}}"><?php _e('Add'); ?></button>
        <button id="themosis-collection-remove" type="button" class="button button-primary themosis-button-remove"><?php _e('Remove'); ?></button>
    </div>
    @if(isset($field['info']))
    <div class="themosis-field-info">
        <p>{{ $field['info'] }}</p>
    </div>
    @endif
</div>
<!-- End collection field -->


@if(isset($field['info']))
<div class="themosis-field-info">
    <p>{{ $field['info'] }}</p>
</div>
@endif