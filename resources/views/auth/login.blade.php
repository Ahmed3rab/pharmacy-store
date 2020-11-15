@extends('layouts.auth')

@section('content')
    <div class="min-h-screen flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8">
        <div class="max-w-md w-full">
            <div>
                <svg class="h-32 w-32 mx-auto" viewBox="0 0 148 148" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M133.56 85.7254C131.972 93.2731 128.868 100.419 124.435 106.731C123.505 108.046 122.527 109.33 121.508 110.558C126.124 95.5261 126.965 79.5884 123.957 64.1541C121.581 51.8757 116.82 40.1828 109.943 29.7378C108.825 28.0267 107.644 26.3506 106.406 24.7115C107.779 25.5111 109.125 26.3606 110.419 27.2771C116.57 31.5583 121.811 37.0176 125.837 43.3388C129.864 49.66 132.596 56.7174 133.876 64.1021C135.15 71.264 135.041 78.6035 133.555 85.7244L133.56 85.7254ZM109.401 119.633C109.296 119.913 109.201 120.182 109.091 120.458C108.869 121.006 108.652 121.569 108.413 122.114C105.752 123.815 102.952 125.289 100.044 126.52C99.1719 126.759 98.3165 127.011 97.458 127.246C97.4995 127.233 97.5386 127.213 97.574 127.188C98.6093 126.503 100.149 120.621 100.518 119.572C101.465 116.873 102.29 114.13 102.998 111.369C104.414 105.837 105.356 100.193 105.813 94.5006C106.724 83.04 105.663 71.508 102.676 60.4061C98.8274 46.2384 91.8921 33.0979 82.3671 21.927C81.2524 20.4133 80.0463 18.969 78.7556 17.6024C78.5602 17.3734 78.2981 17.2112 78.0061 17.1386C78.6566 17.0946 79.2942 17.0507 79.9418 16.9917H79.9548C83.3781 17.1174 86.7828 17.5566 90.1259 18.304C104.741 34.2022 113.682 54.4931 115.552 76.0087C115.752 78.4454 115.879 80.906 115.907 83.3557C116.056 95.7521 113.849 108.064 109.402 119.636L109.401 119.633ZM87.6326 113.07C86.3867 118.353 84.7335 123.533 82.6879 128.561C82.5 129.031 82.3072 129.505 82.1023 129.978C81.9764 130.278 81.8435 130.578 81.7176 130.878C81.7322 130.867 81.7484 130.858 81.7655 130.851C81.7445 130.871 81.7246 130.889 81.7006 130.909C77.0181 131.257 72.3105 131.013 67.6889 130.183C67.7889 129.907 67.8968 129.628 67.9987 129.342C70.7033 121.979 72.5877 114.34 73.618 106.564C74.5417 99.2276 74.6844 91.8137 74.0437 84.4471C73.3913 76.8636 71.9351 69.3709 69.6996 62.0952C69.4917 61.4406 69.2869 60.7899 69.066 60.1423C66.9039 53.603 64.1113 47.2894 60.7276 41.2905C59.9202 39.8733 51.6027 26.2986 49.4692 24.7525L49.0804 24.6335C53.1437 22.2848 57.4813 20.4466 61.9948 19.1605C62.6453 18.9866 66.4618 24.1578 66.9764 24.7935C78.6769 39.1019 86.3294 56.2849 89.1376 74.5545C91.0598 87.3724 90.5489 100.438 87.6316 113.067L87.6326 113.07ZM46.2833 121.61C45.8576 121.33 45.4249 121.037 44.9991 120.744C38.8506 116.46 33.612 110.999 29.5859 104.678C25.5599 98.3568 22.8262 91.3004 21.5428 83.9164C20.6353 78.8146 20.4242 73.6133 20.9153 68.4548C21.8695 58.682 25.3397 49.3234 30.9875 41.2915C31.2973 40.8657 31.5871 40.44 31.9139 40.0132C47.1226 64.3116 52.2763 93.5769 46.2833 121.61ZM146.859 61.1487C145.172 51.5775 141.617 42.4324 136.396 34.2357C131.175 26.039 124.39 18.9514 116.429 13.3776C108.469 7.80384 99.4883 3.85315 90.0009 1.75121C80.5134 -0.350727 70.7048 -0.56272 61.1353 1.12731C41.8105 4.5372 24.6315 15.4851 13.3775 31.5626C2.12344 47.6402 -2.28371 67.5304 1.12549 86.8578C2.22647 93.1218 4.12847 99.2182 6.78469 104.997C13.6345 119.838 25.2034 131.995 39.6865 139.57C54.1696 147.146 70.7525 149.714 86.8481 146.874C98.8105 144.774 110.071 139.757 119.632 132.267C129.194 124.777 136.761 115.045 141.665 103.933C147.624 90.5108 149.434 75.6139 146.862 61.1557" fill="#AE9F51"/>
                </svg>

                <h2 class="mt-6 text-center text-3xl leading-9 font-extrabold text-gray-900">
                    Sign in to your account
                </h2>
                <p class="mt-2 text-center text-sm leading-5 text-gray-600">
                    Sign in to Arwad'c control panel.
                </p>
            </div>
            <form class="mt-8" action="{{ route('auth.authenticate') }}" method="POST">
                @csrf
                <input type="hidden" name="remember" value="true">
                <div class="rounded-md shadow-sm">
                    <div>
                        <input aria-label="Email address" name="email" type="email" required class="appearance-none rounded-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-t-md focus:outline-none focus:shadow-outline-blue focus:border-arwad-500 focus:z-10 sm:text-sm sm:leading-5" placeholder="Email address">
                    </div>
                    <div class="-mt-px">
                        <input aria-label="Password" name="password" type="password" required class="appearance-none rounded-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-b-md focus:outline-none focus:shadow-outline-blue focus:border-arwad-500 focus:z-10 sm:text-sm sm:leading-5" placeholder="Password">
                    </div>
                </div>

                <div class="mt-6 flex items-center justify-between">
                    <div class="flex items-center">
                        <input id="remember_me" type="checkbox" class="form-checkbox h-4 w-4 text-indigo-600 transition duration-150 ease-in-out">
                        <label for="remember_me" class="ml-2 block text-sm leading-5 text-gray-900">
                            Remember me
                        </label>
                    </div>

                    <div class="text-sm leading-5">
                        <a href="#" class="font-medium text-arwad-500 hover:text-arwad-500 focus:outline-none focus:underline transition ease-in-out duration-150">
                            Forgot your password?
                        </a>
                    </div>
                </div>

                <div class="mt-6">
                    <button type="submit" class="group relative w-full flex justify-center py-2 px-4 border border-transparent text-sm leading-5 font-medium rounded-md text-white bg-arwad-500 hover:bg-arwad-500 focus:outline-none focus:border-indigo-700 focus:shadow-outline-indigo active:bg-indigo-700 transition duration-150 ease-in-out">
                          <span class="absolute left-0 inset-y-0 flex items-center pl-3">
                            <svg class="h-5 w-5 text-white-500 group-hover:text-indigo-400 transition ease-in-out duration-150" fill="currentColor" viewBox="0 0 20 20">
                              <path fill-rule="evenodd" d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z" clip-rule="evenodd" />
                            </svg>
                          </span>
                        Sign in
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection