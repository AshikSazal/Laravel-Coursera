php artisan make:model Book -m
php artisan make:model Review -m
php artisan migrate
php artisan make:factory BookFactory --model=Book
php artisan make:factory ReviewFactory --model=Review
php artisan migrate:refresh --seed // database seed
php artisan make:controller BookController --resource
php artisan tinker > $books = \App\Models\Book::with('reviews')->take(3)->get();

                   > $book = \App\Models\Book::find(1);
                   > $review = $book->reviews()->create(['review'=>'Sample Review', 'rating'=>5]);

                   > $review = \App\Models\Review::with('book')->find(1);

                   > \App\Models\Book::title('delectus')->where('created_at','>','2023-01-01')->toSql(); // It will return sql

                   > \App\Models\Book::withCount('reviews')->withAvg('reviews','rating')->having('reviews_count','>=',10)->orderBy('reviews_avg_rating','desc')->limit(10)->get();

                   > \App\Models\Book::highestRated('2023-01-01','2023-03-30')->popular('2023-01-01','2023-03-30')->minReviews(2)->get();

php artisan make:component StarRating
php artisan make:controller ReviewController --resource
