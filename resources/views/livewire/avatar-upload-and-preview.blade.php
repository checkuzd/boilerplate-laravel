<div>
    @if ($avatarThumb)
        <div class="preview-avatar">
            <img src="{{ $avatarThumb }}">
            <div class="remove" wire:click="remove">X</div>
        </div>
    @elseif ($avatar && ! $errors->has('avatar'))
        <div class="preview-avatar">
            <img src="{{ $avatar->temporaryUrl() }}">
            <div class="remove" wire:click="remove">X</div>
        </div>
    @endif

    <div
        class="upload-avatar {{ ($avatarThumb) ? 'd-none' : '' }}"
        x-data="{ show: true }"
        x-show="show"
        x-init="@this.on('uploaded', () => { show = !show;  })"
    >
        <label>
            <span></span>
            <span>Upload here</span>
            <span>
                <input type="file" name="avatar" wire:model="avatar">
            </span>
        </label>
    </div>

    @error('avatar') <span class="error">{{ $message }}</span> @enderror
</div>
<style>
.preview-avatar{
    border-radius: 50%;
    width: 100px;
    height: 100px;
    position: relative;
}
.preview-avatar .remove {
	position: absolute;
	top: 0;
	width: 100%;
	height: 100%;
	display: flex;
	align-items: center;
	justify-content: center;
	color: white;
	background-color: red;
	border-radius: 50%;
	opacity: 0;
	transition: all .3s ease-in-out;
    cursor: pointer;
}
.preview-avatar:hover .remove{
    opacity: .5;
}

.preview-avatar img{
    border-radius: 50%;
    width: 100%;
    height: 100%;
    object-fit: cover;
}
.upload-avatar {
	padding: 10px;
	position: relative;
	width: 100px;
	height: 100px;
    overflow: hidden;
    border: 2px dashed gray;
	border-radius: 50%;
}
.upload-avatar:hover,
.upload-avatar.drop{
    background-color: #d7d7d7;
}
.upload-avatar label{
    cursor: pointer;
    position: absolute;
    left: 0;
    top: 0;
    width: 100%;
    height: 100%;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-direction: column;
    text-align: center;
}
.upload-avatar label span:nth-child(2){
    position: absolute;
}
.upload-avatar label input{
    opacity: 0;
    scale: 100;
}
</style>
