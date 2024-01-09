<?php

namespace App\Controllers;

class Home extends BaseController
{
    protected $db;
    protected $data = [];

    public function __construct()
    {
        $this->db = \Config\Database::connect();
        helper([
            'date', 'my_date', 'text', 'security', 'page',
            'option','menu','category','service', 'comment',
            'counter',
        ]);

        $this->data['controller'] = 'home';

        //visitor adn views count
        doVisitation($this->db);
        doView($this->db);

        //option popup welcome
        $this->data['bannerWelcome'] = unserialize(getOption('banner_welcome', $this->db));

        //option pengumuman penting banner
        $this->data['bannerPengumuman'] = unserialize(getOption('banner_pengumuman', $this->db));

        //option icon tools kecil kecil
        $this->data['icon'] = json_decode(getOption('icon_tools', $this->db), true);

        //option tools icon
        $this->data['layananInovasi'] = json_decode(getOption('layanan_inovasi', $this->db));

        //option footer
        $this->data['counter'] = [
            'visit' => getOption('counter_visit', $this->db),
            'view'  => getOption('counter_view', $this->db),
        ];
        $this->data['social'] = [
            'youtube'   => getOption('social_youtube', $this->db),
            'instagram' => getOption('social_instagram', $this->db),
            'facebook'  => getOption('social_facebook', $this->db),
            'twitter'   => getOption('social_twitter', $this->db),
        ];
        $this->data['footerLink']       = unserialize(getOption('footer_link', $this->db));
        $this->data['footerContact']    = [
            'footer_address'    => getOption('contact_address', $this->db),
            'footer_phone'      => getOption('contact_phone', $this->db),
            'footer_email'      => getOption('contact_email', $this->db),
            'footer_website'    => getOption('contact_website', $this->db),
        ];

        //new menu tree
        $this->data['menuNewTree1']  = getMenuNewTree('text-light', $this->db);
        $this->data['menuNewTree2']  = getMenuNewTree('text-light', $this->db);

    }

    public function index()
    {
        //session first time in a day
        $displayPopup = true;
        if(session()->firstVisit)
        {
            if(session()->firstVisit == date('Y-m-d', now()))
            {
                $displayPopup = false;
            }
            else
            {
                session()->setTempdata('firstVisit', date('Y-m-d', now()), 86400);
            }
        }
        else
        {
            session()->setTempdata('firstVisit', date('Y-m-d', now()), 86400);
        }
        $this->data['displayPopup'] = $displayPopup;

        //set default featured ID
        $announcement_ID    = 6;
        $newsletter_ID      = 7;
        $announce_IDs       = [];
        $news_IDs           = [];

        //retrieve all ID_category
        $builder = $this->db->table('post');
        $builder->select('ID,ID_category');
        $builder->where('status', '1');
        $result = $builder->get()->getResult();
        foreach($result as $res)
        {
            $ID_cats = explode(',', $res->ID_category);
            if(in_array($announcement_ID, $ID_cats)) $announce_IDs[] = $res->ID;
            if(in_array($newsletter_ID, $ID_cats)) $news_IDs[] = $res->ID;
        }

        //retrieve post data
        $builder->resetQuery();
        $builder = $this->db->table('post');
        $builder->select('title,slug,featured_image,date_created');
        $builder->whereIn('ID', $announce_IDs);
        $builder->where('status', '1');
        $builder->orderBy('date_created', 'DESC');
        $builder->limit(9);
        $result = $builder->get()->getResultArray();
        $this->data['announcement'] = $result;

        //retrieve post data
        $builder->resetQuery();
        $builder = $this->db->table('post');
        $builder->select('title,slug,featured_image,date_created');
        $builder->whereIn('ID', $news_IDs);
        $builder->where('status', '1');
        $builder->orderBy('date_created', 'DESC');
        $builder->limit(9);
        $result = $builder->get()->getResultArray();
        $this->data['newsletter'] = $result;

        return view('home', $this->data);
    }
}
