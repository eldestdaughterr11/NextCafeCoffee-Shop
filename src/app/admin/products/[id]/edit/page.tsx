"use client";
import React, { useState, useEffect } from 'react';
import { useRouter, useParams } from 'next/navigation';
import AdminSidebar from '@/components/AdminSidebar';
import { ArrowLeft, Save, Loader2, UploadCloud, Image as ImageIcon } from 'lucide-react';

export default function EditProductPage() {
  const router = useRouter();
  const params = useParams();
  const [loading, setLoading] = useState(true);
  const [saving, setSaving] = useState(false);
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

  const convertToBase64 = (file: File): Promise<string> => {
    return new Promise((resolve, reject) => {
      const reader = new FileReader();
      reader.readAsDataURL(file);
      reader.onload = () => resolve(reader.result as string);
      reader.onerror = error => reject(error);
    });
  };

  const handleImageUpload = async (e: React.ChangeEvent<HTMLInputElement>) => {
    if (!e.target.files || e.target.files.length === 0) return;
    const file = e.target.files[0];

    if (file.size > 1024 * 1024) {
      alert("Image is too large! Please use a file smaller than 1MB.");
      return;
    }

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
        const base64 = await convertToBase64(file);
        setFormData(prev => ({ ...prev, image: base64 }));
      }
    } catch (err) {
      console.error("Upload error, using fallback:", err);
      try {
        const base64 = await convertToBase64(file);
        setFormData(prev => ({ ...prev, image: base64 }));
      } catch (innerErr) {
        alert("Error processing image");
      }
    } finally {
      setUploadingImage(false);
    }
  };

  useEffect(() => {
    const fetchProduct = async () => {
      try {
        const res = await fetch('/api/products');
        const data = await res.json();
        const found = data.find((p: any) => p.id.toString() === params.id);
        if (found) {
          setFormData({
            name: found.name || '',
            slug: found.slug || '',
            description: found.description || '',
            price: found.price || '',
            category: found.category || '',
            image: found.image || '',
            status: found.status || 'available'
          });
        }
      } catch (err) {
        console.error(err);
      } finally {
        setLoading(false);
      }
    };
    fetchProduct();
  }, [params.id]);

  const handleChange = (e: React.ChangeEvent<HTMLInputElement | HTMLTextAreaElement | HTMLSelectElement>) => {
    setFormData({ ...formData, [e.target.name]: e.target.value });
  };

  const handleSubmit = async (e: React.FormEvent) => {
    e.preventDefault();
    setSaving(true);

    try {
      const res = await fetch(`/api/products/${params.id}`, {
        method: 'PUT',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({
          ...formData,
          price: parseFloat(formData.price)
        }),
      });

      if (res.ok) {
        alert("Product updated successfully!");
        router.push('/admin/products');
      } else {
        const data = await res.json();
        alert(data.error || "Failed to update product");
      }
    } catch (err) {
      console.error(err);
      alert("An error occurred");
    } finally {
      setSaving(false);
    }
  };

  if (loading) {
    return (
      <div className="flex min-h-screen bg-[#FDF8F3]">
        <AdminSidebar />
        <main className="flex-grow pl-64 p-8 flex items-center justify-center">
           <Loader2 className="h-12 w-12 animate-spin text-coffee-900" />
        </main>
      </div>
    );
  }

  return (
    <div className="flex min-h-screen bg-[#FDF8F3]">
      <AdminSidebar />
      <main className="flex-grow pl-64 p-8">
        <button 
          onClick={() => router.back()}
          className="mb-8 flex items-center space-x-2 text-coffee-400 hover:text-coffee-950 transition-colors font-black uppercase text-xs tracking-widest"
        >
          <ArrowLeft className="h-4 w-4" />
          <span>Back to Products</span>
        </button>

        <div className="bg-white rounded-[2rem] p-8 shadow-sm border border-coffee-50 max-w-2xl">
          <h2 className="text-2xl font-black text-coffee-950 mb-8">Edit Product</h2>

          <form onSubmit={handleSubmit} className="space-y-6">
            <div>
              <label className="text-xs font-black uppercase tracking-widest text-coffee-300 ml-1">Product Name</label>
              <input required type="text" name="name" value={formData.name} onChange={handleChange} className="w-full bg-cream-50/50 border border-coffee-100 rounded-xl py-3 px-4 outline-none focus:ring-2 focus:ring-[#C69276] mt-1" />
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
               <label className="text-xs font-black uppercase tracking-widest text-coffee-300 ml-1">Status</label>
               <select name="status" value={formData.status} onChange={handleChange} className="w-full bg-cream-50/50 border border-coffee-100 rounded-xl py-3 px-4 outline-none focus:ring-2 focus:ring-[#C69276] mt-1">
                 <option value="available">Available</option>
                 <option value="sold out">Sold Out</option>
               </select>
            </div>

            <div>
              <label className="text-xs font-black uppercase tracking-widest text-coffee-300 ml-1">Description</label>
              <textarea rows={4} name="description" value={formData.description} onChange={handleChange} className="w-full bg-cream-50/50 border border-coffee-100 rounded-xl py-3 px-4 outline-none focus:ring-2 focus:ring-[#C69276] mt-1 resize-none" />
            </div>

            <button disabled={saving} type="submit" className="w-full bg-[#BC8A5F] text-white py-4 rounded-xl font-bold flex justify-center items-center space-x-2 hover:bg-[#a67a54] transition-all disabled:opacity-50">
              <Save className="h-5 w-5" />
              <span>{saving ? 'Updating...' : 'Update Product'}</span>
            </button>
          </form>
        </div>
      </main>
    </div>
  );
}
