<x-layout-auth>
    <x-slot:title>
        Sign in
    </x-slot:title>
    <!-- Validation Errors -->
    <x-auth-validation-errors class="mb-4" :errors="$errors"/>

    @if($errors->has(\App\Cognito\CognitoClient::USER_NOT_CONFIRMED_EXCEPTION))
        <x-flash-message type="info">
            {{ __('validation.info-email-verification-link')}}
                <a href='{{$verifyUrl}}' class='text-blue-900 underline underline-offset-1 text-bold'><p>{{__("here")}}</p></a>
        </x-flash-message>
    @endif
    <form
        class="flex flex-col   md:pr-[35%] lg:pr-0"
        method="POST" action="{{ route('login') }}"
    >
        @csrf
        <fieldset class="flex flex-col">
            <legend class=" sr-only text-gray-600 text-md mb-2 font-medium">Email</legend>
            <label class="p-4 text-gray-600 text-md mb-2 font-medium" for="email">Email</label>
            <input
                class="form-input peer p-4 mx-4 border-2
			border-transparent border-solid rounded-md bg-[#f7f7f7]
			invalid:border-[#F03434] invalid:text-[#F03434]
			focus:invalid:border-[#F03434]-500 focus:invalid:ring-[#F03434]
			placeholder:text-2xl"
                placeholder="johndoe@example.com"
                maxlength="320"
                type="email"
                name="email"
                id="email"
            />
            <p class="hidden p-4 mx-4   text-red-600 peer-invalid:block">
                E-mail invalid, should be in this format:john@example.com
            </p>
        </fieldset>

        <fieldset class="flex flex-col	">
            <legend class=" sr-only text-gray-600 text-md mb-2 font-medium">Password</legend>
            <label class="p-4 mt-4 text-gray-600 text-md mb-2 font-medium" for="password">Password</label>
            <input
                class="form-input peer p-4 mx-4 border-2 border-transparent
	border-solid rounded-md bg-[#f7f7f7]
	invalid:border-[#F03434] invalid:text-[#F03434]
	focus:invalid:border-[#F03434]-500 focus:invalid:ring-[#F03434]
	placeholder:text-2xl"
                type="password"
                name="password"
                minlength="8"
                id="password"
                placeholder="Enter Your Password"
            />

            <p class="invisible p-4 mx-4   text-[#F03434] peer-invalid:visible">
                Password should be at least 8 characters,1 Uppercase,1 lowercase,1 digits and 1 special
                characters.
            </p>
        </fieldset>

        <input
            class="cursor-pointer bg-black border-2 border-solid
	border-transparent rounded-md
	text-white  p-4 mx-4 mt-8 md:mt-6
	 lg:text-3xl lg:p-6"
            type="submit"
            value="Login"
            name="submit"
        />
        <p class="p-4">
            Not a user yet?<a
                class="underline font-bold text-[#3d9ec9] visited:text-[#551A8B]"
                href="/signup">Create an account</a
            >
        </p>
    </form>
</x-layout-auth>
