<?php

namespace Davidpiesse\StatusPage;

use Laravel\Nova\Card;

class StatusPage extends Card
{
    /**
     * The width of the card (1/3, 1/2, or full).
     *
     * @var string
     */
    public $width = '1/3';

    /**
     * Get the component name for the element.
     *
     * @return string
     */
    public function component()
    {
        return 'StatusPage';
    }

    protected $service_list = [
        'cloudflare' => 'yh6f0r4529hb',
        'newrelic' => '4qjjcrpdj8jh',
        'travisci' => 'travisci',
    ];

    public function page($page_id)
    {
        if(key_exists($page_id, $this->service_list)){
            return $this->withMeta([
                'page_id' => $this->service_list[$page_id]
            ]);
        }else{
            return $this->withMeta([
                'page_id' => $page_id
            ]);
        }
    }
}
