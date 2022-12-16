<?php
/**
 * Created by PhpStorm.
 * User: anton
 * Date: 16.12.22
 * Time: 15.12
 */

namespace App\Http\Controllers;

use App\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class BlogInstancesController extends Controller
{
    /**
     * Create a new AuthController instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:api');
    }


    /**
     * @OA\Post(
     *      path="/api/create-blog-record ",
     *      operationId="createBlogRecord",
     *      tags={"posts"},
     *      summary="create record",
     *      description="Creates posts",
     *      @OA\Parameter(
     *          name="message",
     *          description="creates posts",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="string"
     *          )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *       ),
     *      @OA\Response(
     *          response=401,
     *          description="Unauthenticated",
     *      ),
     */
    public function createBlogRecord(Request $request)
    {
        $validated = $request->validate([
            'message' => 'required'
        ]);

        $post = new Post();
        $post->message = $request->get('message');
        $post->author = Auth::guard('api')->user()->name;
        $post->user_id = Auth::guard('api')->user()->id;
        $post->save();

        return response()->json(['message' => 'Successfully created']);
    }

    public function showBlog(Request $request)
    {
        $posts = Post::all();

        return view('blog', [
            'posts' => $posts
        ]);
    }

    /**
     * @OA\Post(
     *      path="/api/update-blog-record",
     *      operationId="updateBlogRecord",
     *      tags={"posts"},
     *      summary="update record",
     *      description="Updates posts",
     *     @OA\Parameter(
     *          name="id",
     *          description="identifier,
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="string"
     *          )
     *      ),
     *      @OA\Parameter(
     *          name="message",
     *          description="creates posts",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="string"
     *          )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *       ),
     *      @OA\Response(
     *          response=401,
     *          description="Unauthenticated",
     *      ),
     */
    public function updateBlogRecord(Request $request)
    {
        $post = Post::find($request->get('id'));

        if ($request->user()->cannot('update', $post)) {
            return response()->json(['message' => 'Forbidden']);
        }

        $validated = $request->validate([
            'id' => 'required'
        ]);

        $post->message = $request->get('message');
        $post->save();

        return response()->json(['message' => 'Successfully updated']);
    }

    /**
     * @OA\Post(
     *      path="/api/delete-blog-record",
     *      operationId="deleteBlogRecord",
     *      tags={"posts"},
     *      summary="delete record",
     *      description="delete posts",
     *     @OA\Parameter(
     *          name="id",
     *          description="identifier,
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="string"
     *          )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *       ),
     *      @OA\Response(
     *          response=401,
     *          description="Unauthenticated",
     *      ),
     */
    public function deleteBlogRecord(Request $request)
    {
        $post = Post::find($request->get('id'));

        if ($request->user()->cannot('update', $post)) {
            return response()->json(['message' => 'Forbidden']);
        }

        $validated = $request->validate([
            'id' => 'required'
        ]);

        $post->delete();

        return response()->json(['message' => 'Successfully deleted']);
    }

}
