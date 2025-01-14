<?php

/*
 * LMS version 1.11-git
 *
 *  (C) Copyright 2001-2022 LMS Developers
 *
 *  Please, see the doc/AUTHORS for more information about authors!
 *
 *  This program is free software; you can redistribute it and/or modify
 *  it under the terms of the GNU General Public License Version 2 as
 *  published by the Free Software Foundation.
 *
 *  This program is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *  GNU General Public License for more details.
 *
 *  You should have received a copy of the GNU General Public License
 *  along with this program; if not, write to the Free Software
 *  Foundation, Inc., 59 Temple Place - Suite 330, Boston, MA 02111-1307,
 *  USA.
 *
 *  $Id$
 */

if (!empty($_POST['invprojectadd'])) {
    $invproject = $_POST['invprojectadd'];

    if ($invproject['project']=='') {
        $SESSION->redirect('?m=invprojectadd');
    }

    if ($LMS->ProjectByNameExists($invproject['project'])) {
        $error['project'] = trans('Investment project with specified name already exists!');
    }

    if (!$error) {
        $LMS->AddProject(array(
            'project' => $invproject['project'],
            'divisionid' => $invproject['divisionid'],
        ));

        if (!isset($invproject['reuse'])) {
            $SESSION->redirect('?m=invprojectlist');
        }
    }
}

$layout['pagetitle'] = trans('New investment project');

$SESSION->add_history_entry();

$SMARTY->assign('invprojectadd', $invproject);
$SMARTY->assign('divisions', $LMS->GetDivisions());
$SMARTY->assign('error', $error);
$SMARTY->display('invproject/invprojectadd.html');
