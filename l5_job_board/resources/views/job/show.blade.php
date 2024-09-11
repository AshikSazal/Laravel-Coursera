<x-layout>
    <x-breadcrumbs class="mb-4" :links="['Jobs' => route('jobs.index'), $job->title => '#']" />
    {{-- <x-job-card :job="$job"> --}}
    <x-job-card :$job>
        {{-- nl2br used for html tag and e() means escape --}}
        <p class="mb-4 text-sm text-slate-500">{!! nl2br(e($job->description)) !!}</p>
    </x-job-card>
</x-layout>
