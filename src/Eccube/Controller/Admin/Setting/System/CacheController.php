<?php
/*
 * This file is part of EC-CUBE
 *
 * Copyright(c) 2000-2015 LOCKON CO.,LTD. All Rights Reserved.
 *
 * http://www.lockon.co.jp/
 *
 * This program is free software; you can redistribute it and/or
 * modify it under the terms of the GNU General Public License
 * as published by the Free Software Foundation; either version 2
 * of the License, or (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program; if not, write to the Free Software
 * Foundation, Inc., 59 Temple Place - Suite 330, Boston, MA  02111-1307, USA.
 */


namespace Eccube\Controller\Admin\Setting\System;

use Eccube\Application;
use Eccube\Controller\AbstractController;
use Eccube\Util\Cache;
use Symfony\Component\HttpFoundation\Request;

class CacheController extends AbstractController
{

    public function index(Application $app, Request $request)
    {

        $form = $app->form()->getForm();

        if ('POST' === $request->getMethod()) {

            $form->handleRequest($request);

            if ($form->isValid()) {

                switch ($request->get('mode')) {
                    case 'twig':
                        // Twigキャッシュクリア
                        Cache::clear($app, false, true);
                        $app->addSuccess('admin.system.twig.cache.save.complete', 'admin');
                        break;

                    case 'all':
                        // sessionを除くキャッシュクリア
                        Cache::clear($app, false);
                        $app->addSuccess('admin.system.all.cache.save.complete', 'admin');

                        break;

                    default:
                        break;
                }
            }
        }

        return $app->render('Setting/System/cache.twig', array(
            'form' => $form->createView(),
        ));
    }
}
