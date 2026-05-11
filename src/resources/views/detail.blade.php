<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>{{ $product->name }}</title>
    <link rel="stylesheet" href="{{ asset('css/detail.css') }}">
</head>
<body>
    <header class="header">
        <h1 class="header__logo">mogitate</h1>
    </header>

    <main class="detail">
        <form
            class="detail__form-area"
            action="/products/detail/{{ $product->id }}/update"
            method="POST"
                enctype="multipart/form-data"
        >
            @csrf
            @method('PUT')
            <div class="detail__breadcrumb">
                <a href="/products">商品一覧</a>
                <span>></span>
                <span>{{ $product->name }}</span>
            </div>

            <div class="detail__content">
                <div class="detail__image-area">
                    <img class="detail__image" src="{{ asset($product->image) }}" alt="{{ $product->name }}">
                    <input type="file" class="detail__file" name="image">
                </div>

                <div class="detail__form">
                    <label class="detail__label">商品名</label>
                    <input class="detail__input" type="text" name="name" value="{{ $product->name }}">

                    <label class="detail__label">値段</label>
                    <input class="detail__input" type="text" name="price" value="{{ $product->price }}">

                    <label class="detail__label">季節</label>
                    <div class="detail__seasons">
                        @foreach ($seasons as $season)
                            <label>
                                <input
                                    type="checkbox"
                                    name="seasons[]"
                                    value="{{ $season->id }}"
                                    {{ $product->seasons->contains($season->id) ? 'checked' : '' }}
                                >
                                {{ $season->name }}
                            </label>
                        @endforeach
                    </div>
                </div>
            </div>

            <div class="detail__description">
                <label class="detail__label">商品説明</label>
                <textarea class="detail__textarea" name="description">{{ $product->description }}</textarea>
            </div>

            <div class="detail__buttons">
                <a class="detail__back" href="/products">戻る</a>
                <button class="detail__save" type="submit">変更を保存</button>
            </div>
        </form>

        <form
            class="detail__delete-form"
            action="/products/{{ $product->id }}/delete"
            method="POST"
        >
            @csrf
            @method('DELETE')
            <button class="detail__delete" type="submit">🗑</button>
        </form>
    </main>
</body>
</html>