<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Video;

use App\Http\Requests\VideoRequest;
use Illuminate\Support\Facades\Storage;


class VideoController extends Controller
{
    /** 
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $video = Video::all();
        if($video){
            return response()->json([
                'video' => $video
            ],200);
        }
        return response()->json([
            'message' => 'couldn\'t fetch data'
        ],401);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    // public function store(Request $request)
    // {
    //     $data =  $request->all();
    //     $video = new Video;
    //     $video->url = $data['url'];
    //     $video->start = $data['start'];
    //     $video->end = $data['end'];
    //     $video->save();
    //     if($video){
    //         return response()->json([
    //             'video' => $video
    //         ],200);
    //     }
    //     return response()->json([
    //         'message' => 'couldn\'t store data'
    //     ],401);
    
    // }

    public function store(VideoRequest $request)
    // public function store(Request $request)
    {
        // function getYoutubeIdFromUrl($url) {
        //     $parts = parse_url($url);
        //     if(isset($parts['query'])){
        //         parse_str($parts['query'], $qs);
        //     if(isset($qs['v'])){
        //         return $qs['v'];
        //     }else if(isset($qs['vi'])){
        //         return $qs['vi'];
        //     }
        //     }
        //     if(isset($parts['path'])){
        //     $path = explode('/', trim($parts['path'], '/'));
        //   return $path[count($path)-1];
        // }
        // return false;
        // }
        
function getYoutubeIdFromUrl($url)
//  

// {
//     $url_string = parse_url($url, PHP_URL_QUERY);
//     parse_str($url_string, $args);
//     return isset($args['v']) ? $args['v'] : false;
//   }


{

    $yt_rx = '/^((?:https?:)?\/\/)?((?:www|m)\.)?((?:youtube\.com|youtu.be))(\/(?:[\w\-]+\?v=|embed\/|v\/)?)([\w\-]+)(\S+)?$/';
    $has_match_youtube = preg_match($yt_rx, $url, $yt_matches);


    //Then we want the video id which is:
    if($has_match_youtube) {
        $video_id = $yt_matches[5]; 
        $type = 'youtube';
    }

    else {
        $video_id = 0;
        $type = 'none';
    }


    $data['video_id'] = $video_id;
    $data['video_type'] = $type;

    return $video_id;

}

        // $image = $request->file('thumbnail');
        // $path = Storage::disk('public')->put('thumbnail', $image);
        $image = $request->file('thumbnail');
        $path = Storage::disk('public')->put('thumbnails', $image);

        $video = new Video;
        $video->title= $request->get('title');
        $video->description= $request->get('description');  
        // $video->thumbnail= $request->get('thumbnail');  

        $video->thumbnail= $path;

        $video->url= $request->get('url');
        $video->start= $request->get('start');
        $video->end=$request->get('end');
        $video->user_id=$request->get('user_id');

        
        if($request->get('start')>$request->get('end')){
            return response()->json([
                'message' => 'start couldn\'t be greater than end '
            ],401);
        }
        elseif (getYoutubeIdFromUrl($request->get('url'))==false){
            return response()->json([
                'message' => ' url can\'t be in this way  '
            ],401);
        }
        // elseif(){
        //     return response()->json([
        //         'message' => ' this post already exists '
        //     ],401);
        // }
        $NewURL = 'https'.'://www.youtube.com/'.'embed/'.getYoutubeIdFromUrl($request->get('url')).'?start='.$request->get('start').'&end='.$request->get('end') ;
        $video->newUrl= $NewURL;
        $video->save();
        // return $NewURL;
         if($video){
            return response()->json([
                'video' => $video
            ],200);
        }
        return response()->json([
            'message' => 'couldn\'t store data'
        ],401);
    }




    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

        return Video::where('id',$id)->first();
    }

     /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        
        function getYoutubeIdFromUrl($url)

        
        {
        
            $yt_rx = '/^((?:https?:)?\/\/)?((?:www|m)\.)?((?:youtube\.com|youtu.be))(\/(?:[\w\-]+\?v=|embed\/|v\/)?)([\w\-]+)(\S+)?$/';
            $has_match_youtube = preg_match($yt_rx, $url, $yt_matches);
        
        
            //Then we want the video id which is:
            if($has_match_youtube) {
                $video_id = $yt_matches[5]; 
                $type = 'youtube';
            }
        
            else {
                $video_id = 0;
                $type = 'none';
            }
        
        
            $data['video_id'] = $video_id;
            $data['video_type'] = $type;
        
            return $video_id;
        
        }

        // $thumbnail = $request->file('thumbnail');
        // $path = Storage::disk('public')->put('thumbnail', $thumbnail);
        $image = $request->file('thumbnail');
        $path = Storage::disk('public')->put('thumbnails', $image);
        $data = $request->all();
        $video = Video::where('id', $id )->first();
        // $video->title= $request->get('title');
        // $video->description= $request->get('description');
        $video->thumbnail= $path;
        $video->description =$data['description'];
        $video->title =$data['title'];


        // $video->url= $request->get('url');
        // $video->start= $request->get('start');
        // $video->end=$request->get('end');
        // if($request->get('start')>$request->get('end')){
        //     return response()->json([
        //         'message' => 'start couldn\'t be greater than end '
        //     ],401);
        // }
        // elseif (getYoutubeIdFromUrl($request->get('url'))==false){
        //     return response()->json([
        //         'message' => ' url can\'t be in this way  '
        //     ],401);
        // }
        // // elseif(){
        // //     return response()->json([
        // //         'message' => ' this post already exists '
        // //     ],401);
        // // }
        // $NewURL = 'https'.'://www.youtube.com/'.'embed/'.getYoutubeIdFromUrl($request->get('url')).'?start='.$request->get('start').'&end='.$request->get('end') ;
        // $video->newUrl= $NewURL;
        $video->update($data);
        $video->save();
        // return $NewURL;
        
        if($video){
            return response()->json([
                'video' => $video
            ],200);
        }
        return response()->json([
            'message' => 'couldn\'t update data'
        ],401); 
        
    }

        



    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $video = Video::where('id' , $id)->delete();
        if($video){
            return response()->json([
                'message' => 'Success'
            ]);
        }
        return response()->json([
            'message' => 'couldn\'t delete data'
        ]);
    }
}
