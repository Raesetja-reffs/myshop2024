<x-app-layout>
    <x-slot name="header">
        {{ __('GRV') }}
    </x-slot>
    <x-slot name="breadcrum">
        <!--begin::Item-->
        <li class="breadcrumb-item text-muted">
            <a href="{{ route('home') }}" class="text-muted text-hover-primary">
                Home </a>
        </li>
        <!--end::Item-->
        <!--begin::Item-->
        <li class="breadcrumb-item">
            <span class="bullet bg-gray-300 w-5px h-2px"></span>
        </li>
        <!--end::Item-->

        <!--begin::Item-->
        <li class="breadcrumb-item text-dark">
            Dashboard </li>
        <!--end::Item-->
    </x-slot>
    <div class="row gy-5 g-xl-10 m-2">
        <x-dashboard-block title="Not Received POs" :count="$countData['notReceivedPOs']" :link="route('grv.not-received-pos')" icon="tablet-delete" />
        <x-dashboard-block title="Awaiting Auth" :count="$countData['awaitingAuth']" :link="route('grv.awaiting-auth')" icon="lock" />
        <x-dashboard-block title="Received" :count="$countData['received']" :link="route('grv.received')" icon="questionnaire-tablet" />
        <x-dashboard-block title="Queries" :count="$countData['queries']" :link="route('grv.queries')" icon="notepad-edit" />
        <x-dashboard-block title="Issues" :count="$countData['issues']" :link="route('grv.issues')" icon="update-folder" />
    </div>
</x-app-layout>
