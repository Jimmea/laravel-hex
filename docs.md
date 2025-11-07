1. Thêm Product (Create Product)
```
Luồng: Request từ form → Controller → Application Service → Domain Entity (validation) → Repository (lưu DB).
```


2. Xem Chi Tiết Product (View Product Detail)
```
Luồng: ID từ URL → Controller → Application Service → Repository → Trả entity dưới dạng DTO.
```

3. Search Product (Search Products)
```
Luồng: Query từ request → Service → Repo (query DB) → Trả list.
```