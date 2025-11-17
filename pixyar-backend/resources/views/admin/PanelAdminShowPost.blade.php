@extends('admin.layout.master')
@section('route')
داشبورد - {{$profiles->full_name}}
@endsection
@section('srcprofile')
https://proxy-steel-beta-96.vercel.app/api/proxy-image?url={{ urlencode($post->profile->profile_pic ?? asset('admin/img/pro.jpg')) }}
@endsection

@section('main-content')
<section class="min-h-screen bg-gradient-to-br from-gray-900 via-gray-800 to-black text-white flex justify-center py-10 px-4">
    <div class="max-w-4xl w-full backdrop-blur-2xl bg-white/5 rounded-2xl shadow-2xl overflow-hidden border border-white/10 animate-fadeIn">

        {{-- بخش بالا: اطلاعات کاربر --}}
        <div class="flex items-center gap-3 p-5 border-b border-white/10">
            <img src="https://proxy-steel-beta-96.vercel.app/api/proxy-image?url={{ urlencode($post->profile->profile_pic ?? asset('admin/img/pro.jpg')) }}" class="w-12 h-12 rounded-full border border-white/20" alt="profile">
            <div>
                <h2 class="font-semibold text-lg">{{ $post->profile->username }}</h2>
                <p class="text-sm text-gray-400">{{ \Carbon\Carbon::parse($post->created_at)->diffForHumans() }}</p>
            </div>
        </div>

        {{-- محتوای پست --}}
        <div class="relative w-full">
            @if($post->type === 'video')
                <video controls class="w-full max-h-[600px] object-cover rounded-none">
                    <source src="https://proxy-steel-beta-96.vercel.app/api/proxy-image?url={{ urlencode($post->media_url ?? asset('admin/img/pro.jpg')) }}" type="video/mp4">
                </video>
            @else
                <img src="https://proxy-steel-beta-96.vercel.app/api/proxy-image?url={{ urlencode($post->thumbnail_url ?? asset('admin/img/pro.jpg')) }}" class="w-full max-h-[600px] object-cover rounded-none" alt="post image">
            @endif
        </div>

        {{-- کپشن و آمار --}}
        <div class="p-5">
            <p class="text-gray-200 leading-relaxed mb-4">{{ $post->caption }}</p>

            <div class="flex items-center gap-6 text-gray-300 text-base">
                <div class="flex items-center gap-2 hover:text-pink-400 transition">
                    ❤️ <span>{{ number_format($post->likes_count) }}</span>
                </div>
                <div class="flex items-center gap-2 hover:text-blue-400 transition">
                    💬 <span>{{ number_format($post->comments_count) }}</span>
                </div>
                <div class="flex items-center gap-2 hover:text-green-400 transition">
                    👁️‍🗨️ <span>{{ number_format($post->views_count ?? 0) }}</span>
                </div>
            </div>
        </div>

        {{-- دکمه‌ها --}}
        <div class="flex justify-around border-t border-white/10 py-4 text-gray-300 text-sm font-medium">
            <button id="btn-likes" class="hover:text-pink-500 transition"><i class="fa-solid fa-heart"></i> لایک‌ها</button>
            <button id="btn-comments" class="hover:text-blue-400 transition"><i class="fa-solid fa-comment"></i> کامنت‌ها</button>
            <a href="{{ url()->previous() }}" class="hover:text-gray-100 transition"><i class="fa-solid fa-arrow-right"></i> بازگشت</a>
        </div>

        {{-- لیست لایک‌ها --}}
        @if(isset($likes['data']['items']) && count($likes['data']['items']) > 0)
        <div id="likes-section" class="hidden px-5 py-4 border-t border-white/10 transition-all duration-500 ease-in-out opacity-0 max-h-0 overflow-hidden">
            <h3 class="font-semibold text-lg mb-3 text-pink-400 flex items-center gap-2">
                <i class="fa-solid fa-heart"></i> کاربرانی که لایک کرده‌اند
            </h3>
            <div class="flex flex-wrap gap-3 max-h-[300px] overflow-y-auto">
                @foreach($likes['data']['items'] as $like)
                    <div class="flex items-center gap-2 bg-white/10 hover:bg-white/20 backdrop-blur-sm rounded-full px-3 py-1.5 text-sm transition-all duration-300">
                        <img src="https://proxy-steel-beta-96.vercel.app/api/proxy-image?url={{ urlencode($like['profile_pic_url'] ?? asset('admin/img/pro.jpg')) }}" class="w-8 h-8 rounded-full border border-white/20" alt="">
                        <span>{{ $like['full_name'] ?? 'کاربر ناشناس' }} </span>
                    </div>
                @endforeach
            </div>
        </div>
        @endif

        {{-- لیست کامنت‌ها --}}
        @if($post->comments && count($post->comments) > 0)
        <div id="comments-section" class="hidden px-5 py-4 border-t border-white/10 transition-all duration-500 ease-in-out opacity-0 max-h-0 overflow-hidden">
            <h3 class="font-semibold text-lg mb-3 text-blue-400 flex items-center gap-2">
                <i class="fa-solid fa-comment"></i> کامنت‌ها
            </h3>
            <div class="space-y-3 max-h-[300px] overflow-y-auto pr-2">
                @foreach($post->comments as $comment)
                    <div class="flex items-start gap-3 bg-white/5 hover:bg-white/10 rounded-xl p-3 transition">
                        <div>
                            <p class="font-semibold text-gray-100">{{ $comment->username }}</p>
                            <p class="text-gray-300 text-sm mt-1">{{ $comment->text }}</p>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
        @endif

    </div>
</section>

{{-- استایل و انیمیشن --}}
<style>
@keyframes fadeIn {
  from {opacity: 0; transform: translateY(30px);}
  to {opacity: 1; transform: translateY(0);}
}
.animate-fadeIn { animation: fadeIn 0.8s ease-out; }
.max-h-\[300px\]::-webkit-scrollbar { width: 6px; }
.max-h-\[300px\]::-webkit-scrollbar-thumb { background: linear-gradient(to bottom, #666, #aaa); border-radius: 10px; }
.max-h-\[300px\]::-webkit-scrollbar-thumb:hover { background: linear-gradient(to bottom, #999, #ccc); }
</style>

{{-- اسکریپت --}}
<script>
document.addEventListener("DOMContentLoaded", () => {
    const likesBtn = document.getElementById("btn-likes");
    const commentsBtn = document.getElementById("btn-comments");
    const likesSection = document.getElementById("likes-section");
    const commentsSection = document.getElementById("comments-section");

    function toggleSection(section) {
        const isOpen = !section.classList.contains("hidden");
        document.querySelectorAll("#likes-section, #comments-section").forEach(s => {
            s.classList.add("hidden");
            s.style.maxHeight = "0px";
            s.style.opacity = "0";
        });
        if (!isOpen) {
            section.classList.remove("hidden");
            section.style.maxHeight = section.scrollHeight + "px";
            section.style.opacity = "1";
        }
    }

    if (likesBtn && likesSection) likesBtn.addEventListener("click", () => toggleSection(likesSection));
    if (commentsBtn && commentsSection) commentsBtn.addEventListener("click", () => toggleSection(commentsSection));
});
</script>
@endsection
