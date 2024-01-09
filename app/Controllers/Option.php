<?php

namespace App\Controllers;

class Option extends BaseController
{
    protected $data = [];

    public function __construct()
    {
        $this->db = \Config\Database::connect();
        helper([
            'date', 'my_date', 'text', 'security', 'page',
            'option','menu','category','service', 'comment',
        ]);

        $this->data['controller'] = 'option';

        //nav menu badge
        $this->data['unapproveService'] = unapproveServiceCount($this->db);
        $this->data['unapproveComment'] = unapproveCommentCount($this->db);

        //banner welcome dan pengumuman
        $this->data['bannerWelcome']    = unserialize(getOption('banner_welcome', $this->db));
        $this->data['bannerPengumuman'] = unserialize(getOption('banner_pengumuman', $this->db));

        //option layanan inovasi
        $this->data['layananInovasi'] = json_decode(getOption('layanan_inovasi', $this->db));

        //option icon tools informasi lain
        $this->data['icon'] = json_decode(getOption('icon_tools', $this->db));

        //option external links
        $this->data['socials'] = [
            'youtube'   => getOption('social_youtube', $this->db),
            'instagram' => getOption('social_instagram', $this->db),
            'facebook'  => getOption('social_facebook', $this->db),
            'twitter'   => getOption('social_twitter', $this->db),
        ];

        //option external links
        $this->data['externalLink'] = unserialize(getOption('footer_link', $this->db));

        //contact
        $this->data['contactUs'] = [
            'address'   => getOption('contact_address', $this->db),
            'phone'     => getOption('contact_phone', $this->db),
            'email'     => getOption('contact_email', $this->db),
            'website'   => getOption('contact_website', $this->db),
        ];
    }

    public function index()
    {
        //always check authentication
        if(!session()->ID) return redirect()->to('login');

        //halaman statis yang tersedia
        $this->data['halamanStatis'] = [
            [
                'ID'    => '1',
                'title' => 'Daftar Informasi Publik',
                'url'   => base_url('dip'),
            ],
            [
                'ID'    => '2',
                'title' => 'Transparansi',
                'url'   => base_url('transparansi-anggaran'),
            ],
            [
                'ID'    => '3',
                'title' => 'Pengaduan Masyarakat',
                'url'   => base_url('layanan-pengaduan-masyarakat'),
            ],
            [
                'ID'    => '4',
                'title' => 'Permohonan Informasi',
                'url'   => base_url('layanan-permohonan-informasi'),
            ],
            [
                'ID'    => '5',
                'title' => 'Download',
                'url'   => base_url('download-area'),
            ],
        ];

        //halaman dinamis dengan status aktif
        $builder = $this->db->table('page');
        $builder->select('ID,title,slug');
        $builder->where('status', '1');
        $this->data['halamanDinamis'] = $builder->get()->getResultArray();

        //kategori dinamis dengan status aktif
        $builder->resetQuery();
        $builder = $this->db->table('category');
        $builder->select('ID,name');
        $builder->where('status', '1');
        $this->data['kategoriDinamis'] = $builder->get()->getResultArray();

        //new menu
        $this->data['navMenuNew'] = getMenuNewNav($this->db);

        echo view('admin-header', $this->data);
        echo view('option');
        echo view('admin-footer');
    }

    public function save()
    {
        //always check authentication
        if(!session()->ID) return redirect()->to('login');

        //count updated data
        $update = $updated = 0;

        //get post data file
        $allowedExtension   = ['jpg','jpeg','png'];

        //popup welcome
        $bannerWelcome   = $this->request->getFile('fileBannerWelcome');
        if($bannerWelcome->isValid() && !$bannerWelcome->hasMoved())
        {
            $extension = $bannerWelcome->guessExtension();
            if(in_array($extension, $allowedExtension))
            {
                $name   = $bannerWelcome->getRandomName();
                $bannerWelcome->move(ROOTPATH.'public/upload/img', $name);
                $update = updateOption('banner_welcome', serialize([
                    'id'    => 'bannerWelcome',
                    'title' => 'Selamat Datang',
                    'image' =>  base_url('upload/img/'.$name),
                ]), $this->db);
            }
        }
        $updated += $update;

        //banner pengumuman maklumat dsb
        $bannerPengumuman   = $this->request->getFile('fileBannerPengumuman');
        if($bannerPengumuman->isValid() && !$bannerPengumuman->hasMoved())
        {
            $extension = $bannerPengumuman->guessExtension();
            if(in_array($extension, $allowedExtension))
            {
                $name   = $bannerPengumuman->getRandomName();
                $bannerPengumuman->move(ROOTPATH.'public/upload/img', $name);
                $update = updateOption('banner_pengumuman', serialize([
                    'id'    => 'bannerPengumuman',
                    'title' => 'Maklumat Pelayanan',
                    'image' =>  base_url('upload/img/'.$name),
                ]), $this->db);
            }
        }
        $updated += $update;

        //get data icon tools informasi lain
        //$iconToolImages = $this->request->getFileMultiple('iconToolImage');
        $iconToolTitle  = $this->request->getPost('iconToolTitle');
        $iconToolUrl    = $this->request->getPost('iconToolUrl');
        $icon_tools     = json_decode(getOption('icon_tools', $this->db), true);
        for($i=0; $i<2; $i++)
        {
            for($j=0; $j<6; $j++)
            {
                $icon_tools[$i][$j][1]  = $iconToolTitle[$i][$j];
                $icon_tools[$i][$j][2]  = $iconToolUrl[$i][$j];
                //upload jika image dipilih
                $iconToolImage = $this->request->getFile('iconToolImage.'.$i.'.'.$j);
                if($iconToolImage)
                {
                    if($iconToolImage->isValid() && !$iconToolImage->hasMoved())
                    {
                        $name       = $iconToolImage->getRandomName();
                        $extension  = $iconToolImage->guessExtension();
                        if(in_array($extension, $allowedExtension))
                        {
                            $iconToolImage->move(ROOTPATH . 'public/assets/icon-tool', $name);
                            $icon_tools[$i][$j][0]  = $name;
                        }
                    }
                }
            }
        }
        $update = updateOption('icon_tools', json_encode($icon_tools), $this->db);
        $updated += $update;

        //get post data modal tools
        $id         = $this->request->getPost('modalToolsId');
        $icon       = $this->request->getPost('modalToolsIcon');
        $title      = $this->request->getPost('modalToolsTitle');
        $content    = $this->request->getPost('modalToolsContent');

        $data = [];
        for($i=0; $i<count($id); $i++)
        {
            $data[$i] = [
                'id'        => $id[$i],
                'icon'      => $icon[$i],
                'title'     => $title[$i],
                'content'   => $content[$i],
            ];
        }
        $update = updateOption('layanan_inovasi', json_encode($data), $this->db);
        $updated += $update;

        //get social icon links
        $socialYt  = $this->request->getPost('socialYoutube');
        $socialIg  = $this->request->getPost('socialInstagram');
        $socialFb  = $this->request->getPost('socialFacebook');
        $socialTw  = $this->request->getPost('socialTwitter');
        $updated += updateOption('social_youtube', $socialYt, $this->db);
        $updated += updateOption('social_instagram', $socialIg, $this->db);
        $updated += updateOption('social_facebook', $socialFb, $this->db);
        $updated += updateOption('social_twitter', $socialTw, $this->db);

        //get links
        $linkTitle  = $this->request->getPost('exLinkTitle');
        $linkUrl    = $this->request->getPost('exLinkUrl');
        $exLinks    = [];
        for($i=0; $i<count($linkTitle); $i++)
        {
            $exLinks[$i] = [
                'title' => $linkTitle[$i],
                'url'   => $linkUrl[$i],
            ];
        }
        $update = updateOption('footer_link', serialize($exLinks), $this->db);
        $updated += $update;

        //get contact details
        $contactAddress = $this->request->getPost('contactAddress');
        $contactPhone   = $this->request->getPost('contactPhone');
        $contactEmail   = $this->request->getPost('contactEmail');
        $contactWebsite = $this->request->getPost('contactWebsite');
        $updated += updateOption('contact_address', $contactAddress, $this->db);
        $updated += updateOption('contact_phone', $contactPhone, $this->db);
        $updated += updateOption('contact_email', $contactEmail, $this->db);
        $updated += updateOption('contact_website', $contactWebsite, $this->db);

        /**
         * Khusus menu
         */

        $menuIDs    = $this->request->getPost('menu-id');
        $menuTitle  = $this->request->getPost('menu-title');
        $menuURL    = $this->request->getPost('menu-url');

        //just make array from perfect form
        $menuNew    = [
            'menuID'    => $menuIDs,
            'menuTitle' => $menuTitle,
            'menuURL'   => $menuURL,
        ];
        if($menuIDs) $updated += updateOption('menu_new_tree', json_encode($menuNew), $this->db);

        /** End menu */

        //alert and redirect
        if($updated > 0)
        {
            session()->setFlashdata('alert', [
                'type'      => 'success',
                'message'   => 'Berhasil menyimpan perubahan '.$updated.' data.'
            ]);
        }
        else
        {
            session()->setFlashdata('alert', [
                'type'      => 'warning',
                'message'   => 'Tidak ada perubahan data yang disimpan!'
            ]);
        }
        return redirect()->to('option');
    }

}