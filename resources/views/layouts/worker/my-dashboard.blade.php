{{-- md:w-2/4 lg:w-1/3 --}}
@extends('layouts.worker.layout')
@section('content')
    <div class="flex w-full p-4 items-center pb-[70px]" x-data="attendanceScript" x-init="initAttendance">
        <div class="w-full flex flex-col gap-4">
            <div class="flex p-4 w-full flex-col justify-center items-center bg-white shadow-md rounded-md gap-4 text-dark">
                <div class=" rounded-md w-full flex flex-col gap-4 text-dark">
                    <div class="grid grid-cols-2 gap-3 items-center text-pale font-bold text-sm text-center">
                        <div class="bg-dark rounded-md p-2 ">
                            <p>{{ $unpaidAttendance->total . ' hari' }}</p>
                            <p class="font-medium">Total Hadir</p>
                        </div>
                        <div class="bg-dark rounded-md p-2">
                            <p>Rp {{ number_format($unpaidSalary, 0, ',', '.') }}</p>
                            <p class="font-medium">Total Pendapatan</p>
                        </div>
                        <div class="bg-dark rounded-md p-2">
                            <p>3 Form</p>
                            <p class="font-medium">Pekerjaan</p>
                        </div>
                        <div class="bg-dark text-danger rounded-md p-2">
                            <p>Rp {{ number_format($unpaidAttendance?->deduction, 0, ',', '.') }}</p>
                            <p class="font-medium">Total Denda</p>
                        </div>
                    </div>
                </div>

                <div class="flex w-full items-center flex-col font-semibold text-md">
                    <p>Absensi</p>
                    <p class="font-normal">{{ $today }}</p>
                    <template x-if="cameraEnabled === true">
                        <div id="my_camera" class="w-full"></div>
                    </template>
                    <template x-if="cameraEnabled === false">
                        <div class="bg-danger text-white rounded-md px-2 text-sm text-center p-1 mt-2">Beri akses kamera
                        </div>
                    </template>

                </div>
                <div class="flex flex-col gap-2 justify-evenly w-full rounded-md bg-dark text-white p-2 font-semibold">
                    <div class="flex w-full text-sm text-center flex-row gap-2 justify-center items-center">
                        <div class="w-full">
                            <p class="font-bold">Rp {{ number_format($todaySalary, 0, ',', '.') }}</p>
                            <p class="font-semibold">Pendapatan</p>
                        </div>
                        <div class="w-full {{ $todayPenalty?->in_minutes > 0 ? 'text-danger' : '' }}">
                            <p class="font-bold">Rp {{ number_format($todayPenalty?->amount, 0, ',', '.') }}
                                ({{ ($todayPenalty?->in_minutes ?? 0) . ' mnt' }})
                            </p>
                            <p class="font-semibold">Denda</p>
                        </div>
                    </div>
                    <hr>
                    <div class="flex flex-row w-full text-center">
                        <div class="flex flex-col  w-full ">
                            <p class="text-xs">Masuk</p>
                            <p>{{ $todayAttendance?->in_at ?? '--:--' }}
                            </p>
                        </div>
                        <div class="flex flex-col  w-full">
                            <p class="text-xs">Keluar</p>
                            <p>{{ $todayAttendance?->out_at ?? '--:--' }}</p>
                        </div>
                    </div>
                </div>

                <div class="w-full flex text-center">
                    <template x-if="location.lat == 0 && location.long == 0 ">
                        <span class="w-full bg-pale text-dark px-2 py-3 text-sm font-bold rounded-md">Mendapatkan
                            lokasi...</span>
                    </template>
                    <template x-if="location.lat > 0 && location.long > 0 && cameraInitialize === null">
                        <button type="button" x-on:click="initWebcam" x-bind:disabled="!cameraEnabled || @js($disabled)"
                            class="bg-main w-full disabled:bg-pale disabled:text-dark text-white px-2 py-3 text-sm rounded-md font-bold">
                            Absensi <span x-text="location.enabled"></span>
                        </button>
                    </template>
                    <template x-if="location.lat >0 && location.long >0 && cameraInitialize">
                        <form id="f-attendance" method="post" action="" class="w-full" x-init="submitForm">
                            @csrf
                            <input type="hidden" name="lat" x-model="location.lat">
                            <input type="hidden" name="long" x-model="location.long">
                            <input type="hidden" name="image" x-model="image.dataUri">

                        </form>
                    </template>
                </div>

            </div>
            <div class="flex flex-col gap-2 bg-white w-full p-4 rounded-md">
                <p class="font-semibold">Absensi 1 Minggu Terakhir</p>
                <hr>
                <div class="grid grid-cols-5 px-2 gap-y-1 ">
                    <p class="font-semibold col-span-3">Tanggal</p>
                    <p class="font-semibold">Masuk</p>
                    <p class="font-semibold">Keluar</p>
                    @if (count($thisWeekAttendances) == 0)
                        <p class="col-span-3">-----</p>
                        <p>--:--</p>
                        <p>--:--</p>
                    @endif
                    @foreach ($thisWeekAttendances as $item)
                        <p class="col-span-3">{{ $item->date }}</p>
                        <p>{{ $item?->in_at ?? '--:--' }}</p>
                        <p>{{ $item?->out_at ?? '--:--' }}</p>
                    @endforeach


                </div>
            </div>
        </div>
    </div>
@endsection
@section('script-header')
    <script src="{{ asset('js/webcam.min.js') }}"></script>
@endsection

@push('script')
    <script>
        var shutter = new Audio();
        shutter.src = navigator.userAgent.match(/Firefox/) ? "{{ asset('audio/shutter.ogg') }}" :
            "{{ asset('audio/shutter.mp3') }}";
        shutter.autoplay = false

        function attendanceScript() {
            return {
                cameraEnabled: null,
                location: {
                    lat: 0,
                    long: 0
                },
                cameraInitialize: null,
                image: {
                    dataUri: null
                },

                initAttendance: function() {
                    this.getLocation()
                    this.checkCamera()
                },

                getLocation: function() {
                    var location = this.location
                    if (navigator.geolocation) {
                        navigator.geolocation.getCurrentPosition((position) => {
                            location.lat = position.coords.latitude
                            location.long = position.coords.longitude
                        })
                    }
                },

                checkCamera: async function() {
                    this.cameraEnabled = await navigator.mediaDevices.getUserMedia({
                            video: true
                        })
                        .then((stream) => {
                            stream.getTracks().forEach(track => track.stop());
                            return true;
                        })
                        .catch((error) => {
                            return false;
                        });
                },

                async initWebcam() {
                    await this.checkCamera()
                    this.cameraInitialize = false;
                    if (this.cameraEnabled) {
                        var myCamera = document.getElementById('my_camera')
                        Webcam.set({
                            width: myCamera.offsetWidth,
                            height: 260,
                            image_format: 'jpeg',
                            jpeg_quality: 90,
                            unfreeze_snap: false
                        });
                        Webcam.attach('#my_camera');
                        setTimeout(() => {
                            this.cameraInitialize = true
                        }, 3000);
                    }

                },
                submitForm: async function() {
                    var form = document.getElementById("f-attendance")
                    var image = this.image

                    shutter.play();
                    await Webcam.snap(function(data_uri) {
                        image.dataUri = data_uri
                    });

                    if (image.dataUri) {
                        form.submit()
                    } else {
                        var imageIos = document.getElementById('my_camera-ios_img');
                        setInterval(() => {
                            if (imageIos.src) {
                                image.dataUri = imageIos.src
                            }
                            if (image.dataUri) {
                                form.submit()
                            }
                        }, 1000);
                    }

                }
            }
        }
    </script>
@endpush
