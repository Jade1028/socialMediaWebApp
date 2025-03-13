<x-layout>
	<style>
		.w-5{
			display: none;
		}
		.post-card{
			border: 1px solid #ccc;
			padding: 10px;
			margin: 10px 0;
		}
	</style>	
	<h1>Post</h1>
	@foreach($posts as $post)
		<div class="post-card">
			<h2>{{ $post->title }}</h2>
			<p>{{ $post->content }}</p>
		</div>
	@endforeach
		{{$posts->links()}}
</x-layout>