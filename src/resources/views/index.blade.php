<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>商品一覧</title>
    <link rel="stylesheet" href="{{ asset('css/index&search.css') }}">
</head>
<body>
    <header class="header">
        <h1 class="header__logo">mogitate</h1>
    </header>

    <main class="product-list">
        <div class="product-list__header">
            <h2 class="product-list__title">商品一覧</h2>

            <a class="product-list__add-button" href="/products/register">
                + 商品を追加
            </a>
        </div>

        <div class="product-list__content">
            <aside class="search">
                <form action="/products/search" method="GET">
                    <input
                        class="search__input"
                        type="text"
                        name="keyword"
                        placeholder="商品名で検索"
                        value="{{ request('keyword') }}"
                    >

                    <button class="search__button" type="submit">
                        検索
                    </button>

                    <h3 class="search__title">価格順で表示</h3>

                    <select
                        class="search__select"
                         name="sort"
                        onchange="this.form.submit()"
                    >
                        <option value="" selected disabled>
                            価格で並べ替え
                        </option>
                        <option value="high">
                            高い順に表示
                        </option>
                        <option value="low">
                            低い順に表示
                        </option>
                    </select>
                </form>
            </aside>

            <section class="products">
                @foreach ($products as $product)
                    <a class="product-card" href="/products/detail/{{ $product->id }}">
                        <img
                            class="product-card__image"
                            src="{{ asset($product->image) }}"
                            alt="{{ $product->name }}"
                        >
                        <div class="product-card__body">
                            <p class="product-card__name">
                                {{ $product->name }}
                            </p>
                            <p class="product-card__price">
                                ¥{{ number_format($product->price) }}
                            </p>
                        </div>
                    </a>
                @endforeach
            </section>
        </div>
        <div class="pagination">
            {{ $products->links() }}
        </div>
    </main>
</body>
</html>