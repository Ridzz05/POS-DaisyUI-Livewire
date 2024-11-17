<div class="page-wrapper">
    <div class="card mx-auto max-w-lg">
        <form class="card-body" wire:submit='simpan'>
            <h3 class="card-title mx-auto">Update profile</h3>

            <div class="space-y-2 py-4">
                <!-- Nama -->
                <label class="form-control w-full">
                    <div class="label">
                        <span class="label-text">Nama</span>
                    </div>
                    <input type="text" placeholder="Nama anda" @class([
                        'input input-bordered',
                        'input-error' => $errors->first('name'),
                    ]) wire:model='name' />
                </label>

                <!-- Email -->
                <label class="form-control w-full">
                    <div class="label">
                        <span class="label-text">Email</span>
                    </div>
                    <input type="email" placeholder="Alamat email" @class([
                        'input input-bordered',
                        'input-error' => $errors->first('email'),
                    ]) wire:model="email"
                        autocomplete="email" />
                </label>

                <!-- Password -->
                <label class="form-control w-full">
                    <div class="label">
                        <span class="label-text">Password</span>
                    </div>
                    <input type="password" placeholder="Isi apabila ingin merubah password" @class([
                        'input input-bordered',
                        'input-error' => $errors->first('password'),
                    ]) wire:model='password' />
                </label>

                <!-- Role Kasir -->
                <label class="form-control w-full">
                    <div class="label">
                        <span class="label-text">Role</span>
                    </div>
                    <select class="input input-bordered" wire:model="role">
                        <option value="">Pilih Role</option>
                        <option value="kasir">Kasir</option>
                        <option value="admin">Admin</option>
                    </select>
                </label>
            </div>

            <div class="card-actions">
                <button class="btn btn-primary w-full">
                    <x-tabler-check class="size-5" />
                    <span>Simpan</span>
                </button>
            </div>
        </form>
    </div>
</div>
