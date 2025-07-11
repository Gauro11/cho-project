<!DOCTYPE html>
<html lang="en">

<head>
    <base href="/user">
    @include('admin.css')
    <style>
        .half-width {
            width: 48%;
        }

        .input-row {
            display: flex;
            justify-content: space-between;
            gap: 4%;
        }

        .save-button {
            margin-top: 20px;
        }
    </style>
</head>

<body>
    <div class="wrapper">
        @include('admin.sidebar')

        <div class="main">
            @include('admin.header')
            <main class="content">
                <div class="container-fluid p-0">

                    <div class="mb-3">
                        <h1 class="h3 d-inline align-middle">Update Disease</h1>
                    </div>
                    
                    <div class="row">
                        <div class="col-12 col-lg-12">
                            <div class="card">  
                                <div class="card-header">
                                    <h5 class="card-title mb-0">Edit Disease Information</h5>
                                </div>
                                <form action="{{ url('/edit_disease', $disease->id) }}" method="POST">
                                @csrf
                                    @method('POST') <!-- Specify POST method for updating -->
                                    <!-- Disease Name -->
                                    <div class="card-body">
                                        <div class="input-row">
                                            <input type="text" name="diseases" class="form-control half-width" value="{{ $disease->diseases }}" placeholder="Disease Name" required>
                                            <input type="text" name="causative_agent" class="form-control half-width" value="{{ $disease->causative_agent }}" placeholder="Causative Agent" required>
                                        </div>
                                    </div>
                                    <!-- Site of Infection and Mode of Transmission -->
                                    <div class="card-body">
                                        <div class="input-row">
                                            <input type="text" name="site_of_infection" class="form-control half-width" value="{{ $disease->site_of_infection }}" placeholder="Site of Infection" required>
                                            <input type="text" name="mode_of_transmission" class="form-control half-width" value="{{ $disease->mode_of_transmission }}" placeholder="Mode of Transmission" required>
                                        </div>
                                    </div>
                                    <!-- Symptoms -->
                                    <div class="card-body">
                                        <div class="input-row">
                                            <textarea name="symptoms" class="form-control half-width" rows="2" placeholder="Symptoms" required>{{ $disease->symptoms }}</textarea>
                                        </div>
                                    </div>
                                    <!-- Save Button -->
                                    <div class="card-body text-center">
                                        <button type="submit" class="btn btn-primary save-button">Update</button>
                                    </div>
                                </form>
                            </div>
                        </div>

                    </div>
                </div>
            </main>
            @include('admin.footer')
        </div>
    </div>
    @include('admin.js')
</body>
@if(session('success'))
        <script>
            alert("{{ session('success') }}");
        </script>
    @endif

</html>
