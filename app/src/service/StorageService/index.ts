class StorageService {
    get(key: string) {
        return localStorage.getItem(key);
    }

    set(key: string, value: string): void {
        localStorage.setItem(key, value)
    }
}

export default StorageService;
