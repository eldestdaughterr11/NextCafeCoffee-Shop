"use client";
import React, { useState, useEffect } from 'react';
import { useRouter } from 'next/navigation';
import AdminSidebar from '@/components/AdminSidebar';
import { ArrowLeft, Save, UploadCloud, Image as ImageIcon } from 'lucide-react';

export default function AddProductPage() {
  const router = useRouter();

  const [loading, setLoading] = useState(false);
  const [uploadingImage, setUploadingImage] = useState(false);
  const [formData, setFormData] = useState({
    name: '',
    slug: '',
    description: '',
    price: '',
    category: '',
    image: '',
    status: 'available'
  });

  const handleImageUpload = async (e: React.ChangeEvent<HTMLInputElement>) => {
    if (!e.target.files || e.target.files.length === 0) return;
    const file = e.target.files[0];
    setUploadingImage(true);

    const data = new FormData();
    data.append('file', file);

    try {
      const res = await fetch('/api/upload', {
        method: 'POST',
        body: data,
      });
      const result = await res.json();
      if (result.success) {
        setFormData(prev => ({ ...prev, image: result.url }));
      } else {
        alert(result.error || 'Upload failed');
      }
    } catch (err) {
      console.error(err);
      alert("Error uploading image");
    } finally {
      setUploadingImage(false);
    }
  };

  useEffect(() => {
    if (typeof window !== 'undefined') {
      const urlParams = new URLSearchParams(window.location.search);
      const cat = urlParams.get('category');
      if (cat) {
        setFormData(prev => ({ ...prev, category: cat }));
      }
    }
  }, []);

  const generateSlug = (name: string) => {
    return name.toLowerCase().replace(/[^a-z0-9]+/g, '-').replace(/(^-|-$)+/g, '');
  };

  const handleNameChange = (e: React.ChangeEvent<HTMLInputElement>) => {
    const name = e.target.value;
    setFormData({ ...formData, name, slug: generateSlug(name) });
  };

  const handleChange = (e: React.ChangeEvent<HTMLInputElement | HTMLTextAreaElement | HTMLSelectElement>) => {
    setFormData({ ...formData, [e.target.name]: e.target.value });
  };

  const handleSubmit = async (e: React.FormEvent) => {
    e.preventDefault();
    setLoading(true);

    try {
      const res = await fetch('/api/products', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({
          ...formData,
          price: parseFloat(formData.price)
        }),
      });

      if (res.ok) {
        alert("Product added successfully!");
        router.push('/admin/products');
      } else {
        const data = await res.json();
        alert(data.error || "Failed to add product");
      }
    } catch (err) {
      console.error(err);
      alert("An error occurred");
    } finally {
      setLoading(false);
    }
  };

  return (
    <div className="flex min-h-screen bg-[#FDF8F3]">
      <AdminSidebar />
      <main className="flex-grow md:pl-64 p-4 md:p-8">
        <button 
          onClick={() => router.back()}
          className="mb-8 flex items-center space-x-2 text-coffee-400 hover:text-coffee-950 transition-colors font-black uppercase text-xs tracking-widest"
        >
          <ArrowLeft className="h-4 w-4" />
          <span>Back to Products</span>
        </button>

        <div className="bg-white rounded-[2rem] p-8 shadow-sm border border-coffee-50 max-w-2xl">
          <h2 className="text-2xl font-black text-coffee-950 mb-8">Add New Product</h2>

          <form onSubmit={handleSubmit} className="space-y-6">
            <div>
              <label className="text-xs font-black uppercase tracking-widest text-coffee-300 ml-1">Product Name</label>
              <input required type="text" name="name" value={formData.name} onChange={handleNameChange} className="w-full bg-cream-50/50 border border-coffee-100 rounded-xl py-3 px-4 outline-none focus:ring-2 focus:ring-[#C69276] mt-1" />
            </div>

            <div className="grid grid-cols-2 gap-4">
              <div>
                <label className="text-xs font-black uppercase tracking-widest text-coffee-300 ml-1">Price (₱)</label>
                <input required type="number" step="0.01" name="price" value={formData.price} onChange={handleChange} className="w-full bg-cream-50/50 border border-coffee-100 rounded-xl py-3 px-4 outline-none focus:ring-2 focus:ring-[#C69276] mt-1" />
              </div>
              <div>
                <label className="text-xs font-black uppercase tracking-widest text-coffee-300 ml-1">Category</label>
                <input required type="text" name="category" value={formData.category} onChange={handleChange} placeholder="e.g. Cold Brew" className="w-full bg-cream-50/50 border border-coffee-100 rounded-xl py-3 px-4 outline-none focus:ring-2 focus:ring-[#C69276] mt-1" />
              </div>
            </div>

            <div>
              <label className="text-xs font-black uppercase tracking-widest text-coffee-300 ml-1">Product Image</label>
              <div className="mt-1 flex items-center space-x-4">
                <div className="relative w-24 h-24 rounded-xl border-2 border-dashed border-coffee-200 bg-cream-50 flex items-center justify-center overflow-hidden flex-shrink-0">
                  {formData.image ? (
                    <img src={formData.image} alt="Preview" className="w-full h-full object-cover" />
                  ) : (
                    <ImageIcon className="h-8 w-8 text-coffee-200" />
                  )}
                </div>
                <div className="flex-1">
                  <label className="cursor-pointer bg-white border border-coffee-100 px-4 py-3 rounded-xl font-bold text-coffee-600 text-sm hover:bg-cream-50 transition-colors flex items-center justify-center space-x-2 w-full">
                    <UploadCloud className="h-4 w-4" />
                    <span>{uploadingImage ? 'Uploading...' : 'Upload Image from Device'}</span>
                    <input type="file" accept="image/*" className="hidden" onChange={handleImageUpload} disabled={uploadingImage} />
                  </label>
                  <input type="text" name="image" value={formData.image} onChange={handleChange} placeholder="Or enter image URL manualy..." className="w-full bg-cream-50/50 border border-coffee-100 rounded-xl py-2 px-3 outline-none focus:ring-2 focus:ring-[#C69276] mt-2 text-sm" />
                </div>
              </div>
            </div>

            <div>
              <label className="text-xs font-black uppercase tracking-widest text-coffee-300 ml-1">Description</label>
              <textarea rows={4} name="description" value={formData.description} onChange={handleChange} className="w-full bg-cream-50/50 border border-coffee-100 rounded-xl py-3 px-4 outline-none focus:ring-2 focus:ring-[#C69276] mt-1 resize-none" />
            </div>

            <button disabled={loading} type="submit" className="w-full bg-[#BC8A5F] text-white py-4 rounded-xl font-bold flex justify-center items-center space-x-2 hover:bg-[#a67a54] transition-all disabled:opacity-50">
              <Save className="h-5 w-5" />
              <span>{loading ? 'Saving...' : 'Save Product'}</span>
            </button>
          </form>
        </div>
      </main>
    </div>
  );
}
