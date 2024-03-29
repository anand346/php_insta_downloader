<?php
// include_once __DIR__ . '/Instagram.php';
include "Instagram.php";
$error = array();
if(!empty($_POST['url']) && !empty($_POST['action']) && filter_var($_POST['url'], FILTER_VALIDATE_URL)){
    $domain = str_ireplace('www.', '', parse_url($_POST['url'], PHP_URL_HOST));
    if (!empty(explode('.', str_ireplace('www.', '', parse_url($_POST['url'], PHP_URL_HOST)))[1])) {
        $mainDomain = explode('.', str_ireplace('www.', '', parse_url($_POST['url'], PHP_URL_HOST)))[1];
    } else {
        $mainDomain = null;
    }
    if ($domain != 'instagram.com') {
        $error[] = 'URL host must be instagram.com';
        die(json_encode($error));
    }
    $instagram = new Instagram();
    $data = array();
    // preg_match('/instagram.com\/((\w|\.){1,30})/', $_POST['url'], $matches);
    // if (!isset($matches[1]) || ($matches[1] == 'p' && $_POST['action'] != "post")) {
    //     $error[] = 'Invalid username.';
    //     die(json_encode($error));
    // } else {
    //     $username = $matches[1];
    // }
    $data['user'] = array();
    $data['medias'] = array();
    switch ($_POST['action']) {
        case 'photo':
        case 'reel':
        case 'video':
            $data['medias'] = $instagram->getPost($_POST['url']);
            // $data['user'] = $instagram->getProfile(null, false);
        break;
        // case 'profilePic':
        //     $data['user'] = $instagram->getProfile($username, true);
        //     $data['medias'] = $instagram->getProfilePicture($data['user']['username'], false);
        //     break;
        // case 'profile':
        //     if (isset($json['graphql']['user']['username']) != '') {
        //         $data['user'] = $instagram->getProfileFromData($json['graphql']['user']);
        //     } else {
        //         $data['user'] = $instagram->getProfile($username, true);
        //     }
        //     if (isset($json['graphql']['user']['edge_owner_to_timeline_media']['edges']) != '') {
        //         $data['medias'] = $instagram->getPostsFromData($json);
        //     } else {
        //         $data['medias'] = $instagram->getPosts($data['user']['username'], false);
        //     }
        //     break;
        // case 'igtv':
        //     $data['medias'] = $instagram->getIgtvVideos($username, true);
        //     $data['user'] = $instagram->getProfile(null, false);
        //     break;
        // case 'story':
        //     if (isset($json['graphql']['user']['username']) != '') {
        //         $data['user'] = $instagram->getProfileFromData($json['graphql']['user']);
        //     } else {
        //         $data['user'] = $instagram->getProfile($username, true);
        //     }
        //     $data['medias'] = $instagram->getStories($data['user']['id']);
        //     break;
        // case 'highlights':
        //     if (isset($json['graphql']['user']['username']) != '') {
        //         $data['user'] = $instagram->getProfileFromData($json['graphql']['user']);
        //     } else {
        //         $data['user'] = $instagram->getProfile($username, true);
        //     }
        //     $data['medias'] = $instagram->getHighlights($data['user']['id']);
        //     break;
        // case 'privatePost':
        //     $data['medias'] = $instagram->getPrivatePostFromData($json["source"]);
        //     $data['user'] = $instagram->getProfile(null, false);
        //     break;
        default:
            $error[] = 'Invalid Action.';
            die(json_encode($error));
        break;
    }
    echo json_encode($data['medias']);
}

?>